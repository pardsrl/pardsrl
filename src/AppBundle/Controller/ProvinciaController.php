<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Provincia;
use AppBundle\Form\ProvinciaType;

/**
 * Provincia controller.
 *
 */
class ProvinciaController extends Controller
{
    /**
     * Lists all Provincia entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $paginator = $this->get('knp_paginator');

        $provincias = $paginator->paginate(
            $provincias,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:provincia:index.html.twig', array(
            'provincias' => $provincias,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Provincia entity.
     *
     */
    public function newAction(Request $request)
    {
        $provincium = new Provincia();
        $form = $this->createForm('AppBundle\Form\ProvinciaType', $provincium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provincium);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('provincia_index');

        }

        return $this->render('AppBundle:provincia:new.html.twig', array(
            'provincium' => $provincium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Provincia entity.
     *
     */
    public function showAction(Provincia $provincium)
    {


        return $this->render('AppBundle:provincia:show.html.twig', array(
            'provincium' => $provincium
        ));
    }

    /**
     * Displays a form to edit an existing Provincia entity.
     *
     */
    public function editAction(Request $request, Provincia $provincium)
    {
        $deleteForm = $this->createDeleteForm($provincium);
        $editForm = $this->createForm('AppBundle\Form\ProvinciaType', $provincium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provincium);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('provincia_edit', array('id' => $provincium->getId()));
        }

        return $this->render('AppBundle:provincia:edit.html.twig', array(
            'provincium' => $provincium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Provincia entity.
     *
     */
    public function deleteAction(Request $request, Provincia $provincium)
    {
        $form = $this->createDeleteForm($provincium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($provincium);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('provincia_index');
    }

    /**
     * Creates a form to delete a Provincia entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('provincia_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
