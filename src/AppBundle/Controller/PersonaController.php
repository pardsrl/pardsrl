<?php

namespace AppBundle\Controller;

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

        $personas = $em->getRepository('AppBundle:Persona')->findAll();

        $paginator = $this->get('knp_paginator');
        $personas = $paginator->paginate(
            $personas,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        return $this->render('AppBundle:persona:index.html.twig', array(
            'personas' => $personas,
        ));
    }

    /**
     * Creates a new Persona entity.
     *
     */
    public function newAction(Request $request)
    {
        $persona = new Persona();

        $form = $this->createForm('AppBundle\Form\PersonaType', $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rol = $form->get('usuario')->get('roles')->getData();

            $persona->getUsuario()->addRole($rol);

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El usuario se ha creado satisfactoriamente.');

            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush();

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
        $deleteForm = $this->createDeleteForm($persona);

        return $this->render('AppBundle:persona:show.html.twig', array(
            'persona' => $persona,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Persona entity.
     *
     */
    public function editAction(Request $request, Persona $persona)
    {
        $deleteForm = $this->createDeleteForm($persona);
        $editForm = $this->createForm('AppBundle\Form\PersonaType', $persona);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $nuevoRol = $editForm->get('usuario')->get('roles')->getData();

            //limpio los roles anteriores
            $persona->getUsuario()->setRoles(array());

            $persona->getUsuario()->addRole($nuevoRol);


            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El usuario se ha actualizado satisfactoriamente. Para que los cambios de ROLES surgan efectos se debe volver a iniciar sesión');

            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush();

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
            $em = $this->getDoctrine()->getManager();
            $em->remove($persona);
            $em->flush();
        }

        return $this->redirectToRoute('persona_index');
    }

    /**
     * Creates a form to delete a Persona entity.
     *
     * @param Persona $persona The Persona entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Persona $persona)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('persona_delete', array('id' => $persona->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
