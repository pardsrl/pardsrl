<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MensajesController extends Controller
{
    public function notificacionesAction()
    {
        return $this->render('AppBundle:mensajes:notificaciones.html.twig', array(
            // ...
        ));
    }

    public function mailboxAction()
    {
        return $this->render('AppBundle:mensajes:mailbox.html.twig', array(
            // ...
        ));
    }

    public function redactarAction()
    {
        return $this->render('AppBundle:mensajes:redactar.html.twig', array(
            // ...
        ));
    }

}
