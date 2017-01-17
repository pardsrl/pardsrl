<?php

namespace AppBundle\Controller;

use AppBundle\Form\RecursoFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ReporteController extends Controller
{

	public function indexAction(Request $request)
	{

		$em = $this->getDoctrine()->getManager();

		$reporteRepository = $em->getRepository('AppBundle:Recurso');

		$opciones = array(
			'method' => 'GET'
		);


		$recursos = $reporteRepository->getRecursos()->getQuery()->getArrayResult();

		$aRecursos = array() ;

		foreach ($recursos as $recurso){

			$nombre = $recurso['recurso'];

			$aRecursos[] = $nombre;
		}

		$extensiones = $reporteRepository->getExtensiones()->getQuery()->getArrayResult();

		$aExtensiones = array() ;

		foreach ($extensiones as $extension){

			$nombre = $extension['extension'];

			$aExtensiones[] = $nombre;
		}

		$opciones['recursos']    = array_combine($aRecursos, $aRecursos);

		$opciones['extensiones'] = array_combine($aExtensiones, $aExtensiones);


		$recursoFilterType = $this->createForm(RecursoFilterType::class,null,$opciones);

		$recursoFilterType->handleRequest($request);

		$recursosQb = $reporteRepository->getReportes();

		if ($recursoFilterType->isSubmitted() && $recursoFilterType->isValid()) {

			$filters = $recursoFilterType->getData();

			//elimino los filtros vacios
			$filters = array_filter($filters);

			foreach ($filters as $filter => $value ){

				switch ($filter){

					case "recurso":
						$recursosQb->andWhere("rec.recurso = '$value'");
						break;
					case "objetoId":
						$recursosQb->andWhere("rec.objetoId = $value");
						break;
					case "nombreArchivo":
						$recursosQb->andWhere("rec.nombreArchivo LIKE '%$value%'");
						break;
					case "extension":
						$recursosQb->andWhere("rec.extension = '$value'");
						break;
					case "fechaCreacion":

						$fecha = $value->format('Y-m-d');

						$recursosQb->andWhere("rec.fechaCreacion BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'");
						break;

				}

			}
		}
		
		$paginator = $this->get('knp_paginator');

		$recursos = $paginator->paginate(
			$recursosQb,
			$request->query->get('page', 1)  /* page number */,
			10/* limit per page */
		);

		return $this->render('AppBundle:reporte:index.html.twig', array(
			'form'     => $recursoFilterType->createView(),
			'recursos' => $recursos
		));
	}

	public function verPdfAction(Request $request, $id) {

		$em = $this->getDoctrine()->getManager();

		$reporte = $em->find('AppBundle:Reporte',$id);

		if(!$reporte){
			throw $this->createNotFoundException('El reporte especificado no existe.');
		}


		$pdf = base64_decode($reporte->getReporte());


		$response = new Response($pdf);

		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Cache-Control', 'public, must-revalidate');
		$response->headers->set('Content-Description', 'File Transfer');
		$response->headers->set('Pragma', 'Public');
		$response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s'));
		$contentDisposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $reporte->getNombreArchivo());
		$response->headers->set('Content-Disposition', $contentDisposition);
		$response->prepare($request);

		return $response;

	}
}
