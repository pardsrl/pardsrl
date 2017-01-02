<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{

	public function indexAction(Request $request)
	{

		$em = $this->getDoctrine()->getManager();

		$reporteRepository = $em->getRepository('AppBundle:Reporte');

		$reportes = $reporteRepository->findAll();



		return $this->render('AppBundle:reporte:index.html.twig', array(
			'reportes' => $reportes
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
