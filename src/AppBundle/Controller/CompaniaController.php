<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Compania;
use AppBundle\Form\CompaniaType;

/**
 * Compania controller.
 *
 */
class CompaniaController extends Controller
{
    /**
     * Lists all Compania entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $companias = $em->getRepository('AppBundle:Compania')->findAll();

        $paginator = $this->get('knp_paginator');

        $companias = $paginator->paginate(
            $companias,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:compania:index.html.twig', array(
            'companias' => $companias,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Compania entity.
     *
     */
    public function newAction(Request $request)
    {
        $companium = new Compania();
        $form = $this->createForm('AppBundle\Form\CompaniaType', $companium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($companium);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('compania_index');

        }

        return $this->render('AppBundle:compania:new.html.twig', array(
            'companium' => $companium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Compania entity.
     *
     */
    public function showAction(Compania $companium)
    {


        return $this->render('AppBundle:compania:show.html.twig', array(
            'companium' => $companium
        ));
    }

    /**
     * Displays a form to edit an existing Compania entity.
     *
     */
    public function editAction(Request $request, Compania $companium)
    {
        $deleteForm = $this->createDeleteForm($companium);
        $editForm = $this->createForm('AppBundle\Form\CompaniaType', $companium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($companium);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('compania_edit', array('id' => $companium->getId()));
        }

        return $this->render('AppBundle:compania:edit.html.twig', array(
            'companium' => $companium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Compania entity.
     *
     */
    public function deleteAction(Request $request, Compania $companium)
    {
        $form = $this->createDeleteForm($companium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($companium);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('compania_index');
    }

    /**
     * Creates a form to delete a Compania entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compania_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
