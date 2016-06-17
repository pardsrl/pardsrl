<?php

namespace UsuarioBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UsuarioBundle\Entity\Funcionalidad;
use UsuarioBundle\Entity\FuncionalidadAccion;
use UsuarioBundle\Form\FuncionalidadType;

/**
 * Funcionalidad controller.
 *
 */
class FuncionalidadController extends Controller
{
    /**
     * Lists all Funcionalidad entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $funcionalidads = $em->getRepository('UsuarioBundle:Funcionalidad')->findAll();

        $paginator = $this->get('knp_paginator');

        $funcionalidads = $paginator->paginate(
            $funcionalidads,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('UsuarioBundle:funcionalidad:index.html.twig', array(
            'funcionalidads' => $funcionalidads,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Funcionalidad entity.
     *
     */
    public function newAction(Request $request)
    {
        $funcionalidad = new Funcionalidad();

        $form = $this->createForm(FuncionalidadType::class, $funcionalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($funcionalidad);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('funcionalidad_edit', array('id' => $funcionalidad->getId()));

        }

        return $this->render('UsuarioBundle:funcionalidad:new.html.twig', array(
            'funcionalidad' => $funcionalidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Funcionalidad entity.
     *
     */
    public function showAction(Funcionalidad $funcionalidad)
    {


        return $this->render('UsuarioBundle:funcionalidad:show.html.twig', array(
            'funcionalidad' => $funcionalidad
        ));
    }

    /**
     * Displays a form to edit an existing Funcionalidad entity.
     *
     */
    public function editAction(Request $request, Funcionalidad $funcionalidad)
    {
        $deleteForm = $this->createDeleteForm($funcionalidad);
        $editForm = $this->createForm(FuncionalidadType::class, $funcionalidad);

        $funcionalidadesAccionesOriginales = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($funcionalidad->getFuncionalidadesAccion() as $funcionalidadAccion) {
            $funcionalidadesAccionesOriginales->add($funcionalidadAccion);
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();


            // remove the relationship between the tag and the Task
            foreach ($funcionalidadesAccionesOriginales as $funcionalidadAccion) {
                if (false === $funcionalidad->getFuncionalidadesAccion()->contains($funcionalidadAccion)) {
                    // remove the Task from the Tag
                    $funcionalidad->getFuncionalidadesAccion()->removeElement($funcionalidadAccion);

                    // if you wanted to delete the Tag entirely, you can also do that
                    $em->remove($funcionalidadAccion);
                }
            }


            $em->persist($funcionalidad);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('funcionalidad_edit', array('id' => $funcionalidad->getId()));
        }

        return $this->render('UsuarioBundle:funcionalidad:edit.html.twig', array(
            'funcionalidad' => $funcionalidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Funcionalidad entity.
     *
     */
    public function deleteAction(Request $request, Funcionalidad $funcionalidad)
    {
        $form = $this->createDeleteForm($funcionalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($funcionalidad);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('funcionalidad_index');
    }

    /**
     * Creates a form to delete a Funcionalidad entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('funcionalidad_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
