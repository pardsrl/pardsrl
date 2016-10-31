<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipo;
use AppBundle\Entity\Novedad;
use AppBundle\Form\NovedadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NovedadController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:novedad:index.html.twig', array(
            // ...
        ));
    }

    public function nuevaAction(Request $request, Equipo $equipo)
    {

	    $personas = $equipo->getPersonas();

	    //si el usuario no tiene asignado el equipo en cuestión
	    if( !$personas->contains($this->getUser()->getPersona())){
		    throw $this->createNotFoundException() ;
	    }


	    $formView = null;

        $novedades = null;

        $intervencionRepository = $this->getDoctrine()->getRepository('AppBundle:Intervencion');

        $intervencionQb = $intervencionRepository->getUltimaIntervencionByEquipo($equipo);

        $intervencion = $intervencionQb->getQuery()->getOneOrNullResult();

        //dump($intervencion);

        if($intervencion && $intervencion->esApertura()){

            $novedad = new Novedad();

            $novedad->setIntervencion($intervencion);

            $form = $this->createForm(NovedadType::class, $novedad, array(
                'action' => $this->generateUrl('novedad_nueva', array('id' => $equipo->getId())),
                'method' => 'POST',
            ));

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($novedad);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Se ha registrado la novedad satisfactoriamente.');

                return $this->redirectToRoute('novedad_nueva', array('id' => $equipo->getId()));
            }

            $formView = $form->createView();

            $novedadRepository = $this->getDoctrine()->getRepository('AppBundle:Novedad');

            $novedadesQb = $novedadRepository->getNovedadesByIntervencion($intervencion);

            $paginator = $this->get('knp_paginator');

            $novedades = $paginator->paginate(
                $novedadesQb,
                $request->query->get('page', 1)  /* page number */,
                5/* limit per page */
            );

            //dump($novedades);
        }else{
            $this->get('session')->getFlashBag()->add('error', 'Inicie una intervención para registrar una novedad.');
        }

        return $this->render('AppBundle:novedad:nueva.html.twig', array(
            'form'      => $formView,
            'novedades' => $novedades
        ));
    }


    public function cerrarNovedadAction(Request $request, Novedad $novedad)
    {
        $form = $this->createForm(NovedadType::class, $novedad, array(
            'action' => $this->generateUrl('novedad_cerrar', array('id' => $novedad->getId())),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($novedad);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Se ha cerrado la novedad Satisfactoriamente');

        }

        return $this->render('AppBundle:novedad:cerrar_novedad.html.twig', array(
            'form' => $form->createView(),
            'novedad' => $novedad
        ));
    }

}
