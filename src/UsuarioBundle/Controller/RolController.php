<?php

namespace UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UsuarioBundle\Entity\Rol;
use UsuarioBundle\Form\RolType;

/**
 * Rol controller.
 *
 */
class RolController extends Controller
{
    /**
     * Lists all Rol entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rols = $em->getRepository('UsuarioBundle:Rol')->findAll();

        $paginator = $this->get('knp_paginator');

        $rols = $paginator->paginate(
            $rols,
            $request->query->get('page', 1)/* page number */,
            10/* limit per page */
        );

        $deleteForm = $this->createDeleteForm();

        return $this->render('UsuarioBundle:rol:index.html.twig', array(
            'rols' => $rols,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new Rol entity.
     *
     */
    public function newAction(Request $request)
    {
        $rol = new Rol();
        $form = $this->createForm(RolType::class, $rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha guardado satisfactoriamente.');

            return $this->redirectToRoute('rol_edit', array('id' => $rol->getId()));

        }

        return $this->render('UsuarioBundle:rol:new.html.twig', array(
            'rol' => $rol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Rol entity.
     *
     */
    public function showAction(Rol $rol)
    {


        return $this->render('UsuarioBundle:rol:show.html.twig', array(
            'rol' => $rol
        ));
    }

    /**
     * Displays a form to edit an existing Rol entity.
     *
     */
    public function editAction(Request $request, Rol $rol)
    {
        $deleteForm = $this->createDeleteForm($rol);
        $editForm = $this->createForm(RolType::class, $rol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush();

            // set flash messages
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha actualizado satisfactoriamente.');

            return $this->redirectToRoute('rol_edit', array('id' => $rol->getId()));
        }

        return $this->render('UsuarioBundle:rol:edit.html.twig', array(
            'rol' => $rol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Rol entity.
     *
     */
    public function deleteAction(Request $request, Rol $rol)
    {
        $form = $this->createDeleteForm($rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($rol);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha dado de baja satisfactoriamente.');
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error', 'Hubo un error al intentar eliminar el registro.');
            }
        }

        return $this->redirectToRoute('rol_index');
    }

    /**
     * Creates a form to delete a Rol entity.
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rol_delete', array('id' => '__obj_id__')))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
