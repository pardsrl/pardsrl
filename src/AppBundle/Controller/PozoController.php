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

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:pozo:index.html.twig', array(
            'pozos' => $pozos,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Pozo entity.
     *
     */
    public function newAction(Request $request)
    {
        $pozo = new Pozo();
        $form = $this->createForm(PozoType::class, $pozo);
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

        return $this->render('AppBundle:pozo:show.html.twig', array(
            'pozo' => $pozo
        ));
    }

    /**
     * Displays a form to edit an existing Pozo entity.
     *
     */
    public function editAction(Request $request, Pozo $pozo)
    {
        $deleteForm = $this->createDeleteForm($pozo);
        $editForm = $this->createForm(PozoType::class, $pozo);
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
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($pozo);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    'El registro se ha dado de baja satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('pozo_index');
    }

    /**
     * Creates a form to delete a Pozo entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pozo_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm();
    }
}
