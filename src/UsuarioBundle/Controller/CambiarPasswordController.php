<?php

namespace UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UsuarioBundle\Entity\Usuario;
use UsuarioBundle\Event\UsuarioPasswordModificadoEvent;
use UsuarioBundle\Form\CambiarPasswordType;

class CambiarPasswordController extends Controller
{
    public function cambiarPasswordAction(Request $request, Usuario $usuario )
    {
        $form = $this->createForm(CambiarPasswordType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');

	        $dispatcher = $this->get('event_dispatcher');

	        $event = new UsuarioPasswordModificadoEvent($usuario);

	        $dispatcher->dispatch(UsuarioPasswordModificadoEvent::NAME, $event);

            $userManager->updateUser($usuario);

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'La contraseña se ha modificado satisfactoriamente.');

            return $this->redirectToRoute('persona_index');

        }
        
        return $this->render('UsuarioBundle:CambiarPassword:cambiarPassword.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

}
