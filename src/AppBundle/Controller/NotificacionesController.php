<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NotificacionesController extends Controller
{
    public function notificacionesPersonalesAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $notificacionRepository = $em->getRepository('AppBundle:Notificacion');

        $qb = $notificacionRepository->getByPersona($user->getPersona());

        $notificaciones = $notificacionRepository->getUltimos($qb,5)->getQuery()->getResult();

        $cantNoLeidas = $notificacionRepository->getCantidadPersonalesNoLeidas($user->getPersona());

        return $this->render('AppBundle:notificaciones:personales.html.twig', array(
            'ultimas_notificaciones' => $notificaciones,
            'cant_notificaiones'     => $cantNoLeidas
        ));
    }

    public function notificacionesSistemaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notificacionRepository = $em->getRepository('AppBundle:Notificacion');

        $qb = $notificacionRepository->getSistema();

        $notificaciones = $notificacionRepository->getUltimos($qb,5)->getQuery()->getResult();

        $cantNoLeidas = $notificacionRepository->getCantidadSistemaNoLeidas();

        return $this->render('AppBundle:notificaciones:sistema.html.twig', array(
            'ultimas_notificaciones' => $notificaciones,
            'cant_notificaiones'     => $cantNoLeidas
        ));
    }

    public function timelineAction(Request $request,$filtro)
    {

	    $em = $this->getDoctrine()->getManager();

	    $notificacionRepository = $em->getRepository('AppBundle:Notificacion');

	    $qb = $notificacionRepository->getSistema();

		$eventos = array();

	    foreach ($qb->getQuery()->getResult() as $evento){

	    	$k = $evento->getFechaCreacion()->format('d M. Y');

		    if(!array_key_exists($k,$eventos)){

		    	$eventos[$k] = array(
		    		'type' => 'alerta',
				    'data' => array($evento)
			    );

		    }else{
		    	$eventos[$k]['data'][] = $evento;
		    }
	    }

	    //dump($eventos);

	    return $this->render('AppBundle:notificaciones:timeline.html.twig', array(
			'eventos' => $eventos
	    ));
    }

}
