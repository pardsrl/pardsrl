<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Pozo;
use AppBundle\Form\PozoType;

/**
 * Pozo controller.
 *
 */
class PozoController extends Controller
{
    /**
     * Lists all Pozo entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pozos = $em->getRepository('AppBundle:Pozo')->findAll();

        $paginator = $this->get('knp_paginator');

        $pozos = $paginator->paginate(
            $pozos,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        return $this->render('AppBundle:pozo:index.html.twig', array(
            'pozos' => $pozos,
        ));
    }

    /**
     * Creates a new Pozo entity.
     *
     */
    public function newAction(Request $request)
    {
        $pozo = new Pozo();
        $form = $this->createForm('AppBundle\Form\PozoType', $pozo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pozo);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('pozo_index');

        }

        return $this->render('AppBundle:pozo:new.html.twig', array(
            'pozo' => $pozo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pozo entity.
     *
     */
    public function showAction(Pozo $pozo)
    {
        $deleteForm = $this->createDeleteForm($pozo);

        return $this->render('AppBundle:pozo:show.html.twig', array(
            'pozo' => $pozo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pozo entity.
     *
     */
    public function editAction(Request $request, Pozo $pozo)
    {
        $deleteForm = $this->createDeleteForm($pozo);
        $editForm = $this->createForm('AppBundle\Form\PozoType', $pozo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pozo);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('pozo_edit', array('id' => $pozo->getId()));
        }

        return $this->render('AppBundle:pozo:edit.html.twig', array(
            'pozo' => $pozo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pozo entity.
     *
     */
    public function deleteAction(Request $request, Pozo $pozo)
    {
        $form = $this->createDeleteForm($pozo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pozo);
            $em->flush();
        }

        return $this->redirectToRoute('pozo_index');
    }

    /**
     * Creates a form to delete a Pozo entity.
     *
     * @param Pozo $pozo The Pozo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pozo $pozo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pozo_delete', array('id' => $pozo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
