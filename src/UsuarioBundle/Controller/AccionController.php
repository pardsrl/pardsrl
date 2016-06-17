<?php

namespace UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UsuarioBundle\Entity\Accion;
use UsuarioBundle\Form\AccionType;

/**
 * Accion controller.
 *
 */
class AccionController extends Controller
{
    /**
     * Lists all Accion entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $accions = $em->getRepository('UsuarioBundle:Accion')->findAll();

        $paginator = $this->get('knp_paginator');

        $accions = $paginator->paginate(
            $accions,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('UsuarioBundle:accion:index.html.twig', array(
            'accions' => $accions,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Accion entity.
     *
     */
    public function newAction(Request $request)
    {
        $accion = new Accion();
        $form = $this->createForm('UsuarioBundle\Form\AccionType', $accion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accion);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('accion_index');

        }

        return $this->render('UsuarioBundle:accion:new.html.twig', array(
            'accion' => $accion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Accion entity.
     *
     */
    public function showAction(Accion $accion)
    {


        return $this->render('UsuarioBundle:accion:show.html.twig', array(
            'accion' => $accion
        ));
    }

    /**
     * Displays a form to edit an existing Accion entity.
     *
     */
    public function editAction(Request $request, Accion $accion)
    {
        $deleteForm = $this->createDeleteForm($accion);
        $editForm = $this->createForm('UsuarioBundle\Form\AccionType', $accion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accion);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('accion_edit', array('id' => $accion->getId()));
        }

        return $this->render('UsuarioBundle:accion:edit.html.twig', array(
            'accion' => $accion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Accion entity.
     *
     */
    public function deleteAction(Request $request, Accion $accion)
    {
        $form = $this->createDeleteForm($accion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($accion);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('accion_index');
    }

    /**
     * Creates a form to delete a Accion entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('accion_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
