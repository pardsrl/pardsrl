<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Equipo;
use AppBundle\Form\EquipoType;

/**
 * Equipo controller.
 *
 */
class EquipoController extends Controller
{
    /**
     * Lists all Equipo entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $equipos = $em->getRepository('AppBundle:Equipo')->findAll();

        $paginator = $this->get('knp_paginator');

        $equipos = $paginator->paginate(
            $equipos,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('AppBundle:equipo:index.html.twig', array(
            'equipos' => $equipos,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Equipo entity.
     *
     */
    public function newAction(Request $request)
    {
        $equipo = new Equipo();
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipo);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('equipo_index');

        }

        return $this->render('AppBundle:equipo:new.html.twig', array(
            'equipo' => $equipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Equipo entity.
     *
     */
    public function showAction(Equipo $equipo)
    {


        return $this->render('AppBundle:equipo:show.html.twig', array(
            'equipo' => $equipo
        ));
    }

    /**
     * Displays a form to edit an existing Equipo entity.
     *
     */
    public function editAction(Request $request, Equipo $equipo)
    {
        $deleteForm = $this->createDeleteForm($equipo);
        $editForm = $this->createForm(EquipoType::class, $equipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipo);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('equipo_edit', array('id' => $equipo->getId()));
        }

        return $this->render('AppBundle:equipo:edit.html.twig', array(
            'equipo' => $equipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Equipo entity.
     *
     */
    public function deleteAction(Request $request, Equipo $equipo)
    {
        $form = $this->createDeleteForm($equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($equipo);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('equipo_index');
    }

    /**
     * Creates a form to delete a Equipo entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipo_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Muestra estadisticas del equipo
     *
     * @param Request $request
     * @param Equipo $equipo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function estadisticasAction(Request $request, Equipo $equipo){

        return $this->render('AppBundle:equipo:estadisticas.html.twig', array(
            'equipo'           => $equipo
        ));
    }

    /**
     * Muestra los instrumentos del equipo
     *
     * @param Request $request
     * @param Equipo $equipo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function instrumentosAction(Request $request, Equipo $equipo)
    {
        return $this->render('AppBundle:equipo:instrumentos.html.twig', array(
            'equipo' => $equipo
        ));
    }

}
