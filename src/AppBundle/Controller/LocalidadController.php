<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Localidad;
use AppBundle\Form\LocalidadType;

/**
 * Localidad controller.
 *
 */
class LocalidadController extends Controller
{
    /**
     * Lists all Localidad entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $localidads = $em->getRepository('AppBundle:Localidad')->findAll();

        $paginator = $this->get('knp_paginator');

        $localidads = $paginator->paginate(
            $localidads,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        return $this->render('AppBundle:localidad:index.html.twig', array(
            'localidads' => $localidads,
        ));
    }

    /**
     * Creates a new Localidad entity.
     *
     */
    public function newAction(Request $request)
    {
        $localidad = new Localidad();
        $form = $this->createForm('AppBundle\Form\LocalidadType', $localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($localidad);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('localidad_index');

        }

        return $this->render('AppBundle:localidad:new.html.twig', array(
            'localidad' => $localidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Localidad entity.
     *
     */
    public function showAction(Localidad $localidad)
    {
        $deleteForm = $this->createDeleteForm($localidad);

        return $this->render('AppBundle:localidad:show.html.twig', array(
            'localidad' => $localidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Localidad entity.
     *
     */
    public function editAction(Request $request, Localidad $localidad)
    {
        $deleteForm = $this->createDeleteForm($localidad);
        $editForm = $this->createForm('AppBundle\Form\LocalidadType', $localidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($localidad);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('localidad_edit', array('id' => $localidad->getId()));
        }

        return $this->render('AppBundle:localidad:edit.html.twig', array(
            'localidad' => $localidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Localidad entity.
     *
     */
    public function deleteAction(Request $request, Localidad $localidad)
    {
        $form = $this->createDeleteForm($localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($localidad);
            $em->flush();
        }

        return $this->redirectToRoute('localidad_index');
    }

    /**
     * Creates a form to delete a Localidad entity.
     *
     * @param Localidad $localidad The Localidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Localidad $localidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localidad_delete', array('id' => $localidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
