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

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:localidad:index.html.twig', array(
            'localidads' => $localidads,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Localidad entity.
     *
     */
    public function newAction(Request $request)
    {
        $localidad = new Localidad();
        $form = $this->createForm(LocalidadType::class, $localidad);
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


        return $this->render('AppBundle:localidad:show.html.twig', array(
            'localidad' => $localidad
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
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($localidad);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('localidad_index');
    }

    /**
     * Creates a form to delete a Localidad entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localidad_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
