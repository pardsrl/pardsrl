<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuracion;
use AppBundle\Event\PersonaActualizadaEvent;
use AppBundle\Event\PersonaCreadaEvent;
use AppBundle\Event\PersonaEliminadaEvent;
use AppBundle\Form\ConfiguracionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Persona;
use AppBundle\Form\PersonaType;

/**
 * Persona controller.
 *
 */
class PersonaController extends Controller
{
    /**
     * Lists all Persona entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

	    $roles = $em->getRepository('UsuarioBundle:Rol')->findAll();

        $personas = $em->getRepository('AppBundle:Persona')->findAll();

        $paginator = $this->get('knp_paginator');

        $personas = $paginator->paginate(
            $personas,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:persona:index.html.twig', array(
            'personas'    => $personas,
            'delete_form' => $deleteForm->createView(),
	        'roles'       => $roles
        ));
    }

    /**
     * Creates a new Persona entity.
     *
     */
    public function newAction(Request $request)
    {
        $persona = new Persona();
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

	        $rol = $form->get('usuario')->get('roles')->getData();

	        $persona->getUsuario()->setRoles(array());
	        $persona->getUsuario()->addRole($rol);

        	$em = $this->getDoctrine()->getManager();

	        $configuracion = new Configuracion();

	        $configuracion->setPersona($persona);

	        $persona->setConfiguracion($configuracion);

            $em->persist($persona);

	        $em->flush();

	        $dispatcher = $this->get('event_dispatcher');

	        $event = new PersonaCreadaEvent($persona);

	        $dispatcher->dispatch(PersonaCreadaEvent::NAME, $event);

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('persona_index');

        }

        return $this->render('AppBundle:persona:new.html.twig', array(
            'persona' => $persona,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Persona entity.
     *
     */
    public function showAction(Persona $persona)
    {


        return $this->render('AppBundle:persona:show.html.twig', array(
            'persona' => $persona
        ));
    }

    /**
     * Displays a form to edit an existing Persona entity.
     *
     */
    public function editAction(Request $request, Persona $persona)
    {
        $deleteForm = $this->createDeleteForm($persona);
        $editForm = $this->createForm(PersonaType::class, $persona);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $rol = $editForm->get('usuario')->get('roles')->getData();

            $persona->getUsuario()->setRoles(array());
            $persona->getUsuario()->addRole($rol);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('persona_edit', array('id' => $persona->getId()));
        }

        return $this->render('AppBundle:persona:edit.html.twig', array(
            'persona' => $persona,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Persona entity.
     *
     */
    public function deleteAction(Request $request, Persona $persona)
    {
        $form = $this->createDeleteForm($persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();

                $em->remove($persona);

	            $dispatcher = $this->get('event_dispatcher');

	            $event = new PersonaEliminadaEvent($persona);

	            $dispatcher->dispatch(PersonaEliminadaEvent::NAME, $event);

                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){

                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('persona_index');
    }

    /**
     * Creates a form to delete a Persona entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('persona_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    /**
     * Lists all Persona entities.
     *
     */
    public function perfilAction(Request $request)
    {

    	$persona = $this->getUser()->getPersona();

	    $configuracion = $persona->getConfiguracion();

	    if(!$configuracion){

	    	$configuracion = new Configuracion();

		    $configuracion->setPersona($persona);

	    }

    	$form = $this->createForm(ConfiguracionType::class,$configuracion);

	    $form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid()) {

		    $em = $this->getDoctrine()->getManager();


		    $config = array();


		    foreach ($form->getIterator() as $key => $child) {

			    $config[$key] = $child->getData();
		    }

	    	$configuracion->setPersona($persona);

		    $configuracion->setConfiguracion($config);

		    $em->persist($configuracion);

		    $em->flush();

	    }

        return $this->render('AppBundle:persona:perfil.html.twig', array(
        	'form'      => $form->createView(),
	        'persona'   => $persona
        ));
    }
}
