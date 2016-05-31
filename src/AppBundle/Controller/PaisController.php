<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Pais;
use AppBundle\Form\PaisType;

/**
 * Pais controller.
 *
 */
class PaisController extends Controller
{
    /**
     * Lists all Pais entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pais = $em->getRepository('AppBundle:Pais')->findAll();

        $paginator = $this->get('knp_paginator');

        $pais = $paginator->paginate(
            $pais,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:pais:index.html.twig', array(
            'pais' => $pais,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Pais entity.
     *
     */
    public function newAction(Request $request)
    {
        $pai = new Pais();
        $form = $this->createForm('AppBundle\Form\PaisType', $pai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pai);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('pais_index');

        }

        return $this->render('AppBundle:pais:new.html.twig', array(
            'pai' => $pai,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pais entity.
     *
     */
    public function showAction(Pais $pai)
    {


        return $this->render('AppBundle:pais:show.html.twig', array(
            'pai' => $pai
        ));
    }

    /**
     * Displays a form to edit an existing Pais entity.
     *
     */
    public function editAction(Request $request, Pais $pai)
    {
        $deleteForm = $this->createDeleteForm($pai);
        $editForm = $this->createForm('AppBundle\Form\PaisType', $pai);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pai);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('pais_edit', array('id' => $pai->getId()));
        }

        return $this->render('AppBundle:pais:edit.html.twig', array(
            'pai' => $pai,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pais entity.
     *
     */
    public function deleteAction(Request $request, Pais $pai)
    {
        $form = $this->createDeleteForm($pai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($pai);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('pais_index');
    }

    /**
     * Creates a form to delete a Pais entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pais_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
