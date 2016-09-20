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

    public function timelineAction(Request $request, $filtro)
    {

	    $em = $this->getDoctrine()->getManager();

	    $persona = $this->getUser()->getPersona();

	    $notificacionRepository = $em->getRepository('AppBundle:Notificacion');

	    switch ($filtro){

		    case 'alertas':
			    $qb = $notificacionRepository->getSistema();

			    break;
		    case 'notificaciones':
			    $qb = $notificacionRepository->getByPersona($persona);

			    break;
		    default:
			    $qb = $notificacionRepository->getTodasNotificaciones($persona);

			    break;
	    }


	    $qb = $notificacionRepository->getUltimos($qb,30);

		$eventos = array();

	    foreach ($qb->getQuery()->getResult() as $evento){

	    	$k = $evento->getfechaCreacion()->format('d M. Y');

		    $type = null;

			$eventos[$k][] = $evento;
	    }

	    return $this->render('AppBundle:notificaciones:timeline.html.twig', array(
			'eventos' => $eventos
	    ));
    }

}
