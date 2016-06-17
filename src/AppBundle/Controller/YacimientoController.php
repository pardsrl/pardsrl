<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Yacimiento;
use AppBundle\Form\YacimientoType;

/**
 * Yacimiento controller.
 *
 */
class YacimientoController extends Controller
{
    /**
     * Lists all Yacimiento entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $yacimientos = $em->getRepository('AppBundle:Yacimiento')->findAll();

        $paginator = $this->get('knp_paginator');

        $yacimientos = $paginator->paginate(
            $yacimientos,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:yacimiento:index.html.twig', array(
            'yacimientos' => $yacimientos,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Yacimiento entity.
     *
     */
    public function newAction(Request $request)
    {
        $yacimiento = new Yacimiento();
        $form = $this->createForm(YacimientoType::class, $yacimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($yacimiento);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('yacimiento_index');

        }

        return $this->render('AppBundle:yacimiento:new.html.twig', array(
            'yacimiento' => $yacimiento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Yacimiento entity.
     *
     */
    public function showAction(Yacimiento $yacimiento)
    {


        return $this->render('AppBundle:yacimiento:show.html.twig', array(
            'yacimiento' => $yacimiento
        ));
    }

    /**
     * Displays a form to edit an existing Yacimiento entity.
     *
     */
    public function editAction(Request $request, Yacimiento $yacimiento)
    {
        $deleteForm = $this->createDeleteForm($yacimiento);
        $editForm = $this->createForm('AppBundle\Form\YacimientoType', $yacimiento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($yacimiento);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('yacimiento_edit', array('id' => $yacimiento->getId()));
        }

        return $this->render('AppBundle:yacimiento:edit.html.twig', array(
            'yacimiento' => $yacimiento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Yacimiento entity.
     *
     */
    public function deleteAction(Request $request, Yacimiento $yacimiento)
    {
        $form = $this->createDeleteForm($yacimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($yacimiento);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('yacimiento_index');
    }

    /**
     * Creates a form to delete a Yacimiento entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('yacimiento_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
