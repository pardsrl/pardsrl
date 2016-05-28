<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NotificacionesController extends Controller
{
    public function notificacionesPersonalesAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

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
        
        
        return $this->render('AppBundle:notificaciones:sistema.html.twig', array(
            // ...
        ));
    }

}
