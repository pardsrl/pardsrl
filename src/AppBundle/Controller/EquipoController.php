<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intervencion;
use AppBundle\Form\EstadisticaGeneralFechaFilterType;
use Doctrine\Common\Collections\ArrayCollection;
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
     * Muestra graficas del equipo
     *
     * @param Request $request
     * @param Equipo $equipo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function graficasAction(Request $request, Equipo $equipo){


        $intervencionRepository = $this->getDoctrine()->getRepository('AppBundle:Intervencion');

        $intervencionQb = $intervencionRepository->getUltimasIntervencionesByEquipo($equipo);

        $intervenciones = $intervencionQb->getQuery()->getResult();


        $intervenciones = new ArrayCollection($intervenciones);

        $fechaInicioIntervencion = null;

        if(!$intervenciones->isEmpty()){

            $intervencionActual = $intervenciones->first();

            if($intervencionActual->getPozo()->estaAbierto()){

                $fechaInicioIntervencion = $intervencionActual->getFecha();

            }else{
                //si está cerrado busco la intervencion de apertura
                $intervencion = $intervenciones->get(1);

                if($intervencion){
                    $fechaInicioIntervencion = $intervencion->getFecha();
                }

            }

        }

        return $this->render('AppBundle:equipo:graficas.html.twig', array(
            'equipo'           => $equipo,
            'fechaInicioIntervencion' => $fechaInicioIntervencion
        ));
    }


    /**
     * Muestra graficas históricas del equipo
     *
     * @param Request $request
     * @param Equipo $equipo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function graficasHistoricasAction(Request $request, Equipo $equipo,$fintervencion,$fdesde,$fhasta){


        return $this->render('AppBundle:equipo:graficas_historicas.html.twig', array(
            'equipo'        => $equipo,
            'fdesde'        => $fdesde,
            'fhasta'        => $fhasta,
            'fintervencion' => $fintervencion
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

    /**
     * Muestra los estadisticas del equipo
     *
     * @param Request $request
     * @param Equipo $equipo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function estadisticasAction(Request $request, Equipo $equipo)
    {

        $intervencionRepository = $this->getDoctrine()->getRepository('AppBundle:Intervencion');

        $intervencionQb = $intervencionRepository->getUltimaIntervencionByEquipo($equipo);

        $intervencion = $intervencionQb->getQuery()->getOneOrNullResult();

        $datos = null;

        $estadisticaManiobra = null;
        //dump($intervencion);

        if ($intervencion && $intervencion->getPozo()->estaAbierto()) {

        } else {
            //Puede ser que exista una intervencion pero haya sido un cierre
            $intervencion = null;
            $this->get('session')->getFlashBag()->add('error',
                'Inicie una intervención para visualizar las estadísticas del pozo actual.');
        }


        return $this->render('AppBundle:equipo:estadisticas.html.twig', array(
            'equipo'       => $equipo,
            'intervencion' => $intervencion
        ));
    }

    public function estadisticasDatosAction(Request $request, $equipo_id, $intervencion_id){

            $equipo = $this->getDoctrine()->getManager()->find('AppBundle:Equipo',$equipo_id);

            $intervencion = $this->getDoctrine()->getManager()->find('AppBundle:Intervencion',$intervencion_id);

            $estadisticas = $intervencion->getEquipo()->getEstadisticas();

	        $datos = null;

            if(!$estadisticas->isEmpty()){
                $datos = $estadisticas->first()->getDatos();
            }

            $novedadRepository = $this->getDoctrine()->getRepository('AppBundle:Novedad');

            $maniobraActualAsistida = $novedadRepository->getActualAsistidaByIntervencion($intervencion)->getQuery()->getOneOrNullResult();

            $maniobraActualAutomatica = $novedadRepository->getActualAutomaticaByIntervencion($intervencion)->getQuery()->getOneOrNullResult();

            $estadisticaManiobra = [];

            $fechaActual = new \DateTime();

            if($maniobraActualAsistida){

                $estadisticaManiobra['actual_asistida'] = array(
                    'maniobra'          => $maniobraActualAsistida->getManiobra(),
                    'iniciado'          => $maniobraActualAsistida->getInicio()->format('d/m/Y H:i:s'),
                    'parcial_maniobra'  => $maniobraActualAsistida->getParcialManiobra(),
                    'promedio_uh'       => $maniobraActualAsistida->getPromedioUh(),
                    'cant_alertas'      => $maniobraActualAsistida->getCantidadAlertas(),
                    'tiempo_parcial'    => $maniobraActualAsistida->getInicio()->diff($fechaActual)->format('%a %H:%I')
                );

            }

            if($maniobraActualAutomatica){

                $estadisticaManiobra['actual_automatica'] = array(
                    'maniobra'          => $maniobraActualAutomatica->getManiobra(),
                    'iniciado'          => $maniobraActualAutomatica->getInicio()->format('d/m/Y H:i:s'),
                    'parcial_maniobra'  => $maniobraActualAutomatica->getParcialManiobra(),
                    'promedio_uh'       => $maniobraActualAutomatica->getPromedioUh(),
                    'cant_alertas'      => $maniobraActualAutomatica->getCantidadAlertas(),
                    'tiempo_parcial'    => $maniobraActualAutomatica->getInicio()->diff($fechaActual)->format('%a %H:%I')
                );

            }



        return $this->render('AppBundle:equipo:estadisticas_datos.html.twig', array(
            'equipo' => $equipo,
            'intervencion' => $intervencion,
            'datos' => $datos,
            'estadistica_maniobra' => $estadisticaManiobra,
        ));
    }

    /**
     * Muestra la pantalla de graficas individuales estadisticas para un equipo
     */
    public function estadisticasIndividualesAction(Request $request, Equipo $equipo){

        $desde = new \DateTime('now');

        $desde = $desde->modify('-1 year');

        $hasta = new \DateTime('now');

        $rangoFechas = array(
            'desde' => $desde,
            'hasta' => $hasta
        );

        $form = $this->createForm(EstadisticaGeneralFechaFilterType::class,$rangoFechas, array(
            'method'        => 'POST'
        ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $desde = $data['desde'];

            $hasta = $data['hasta'];
        }

        return $this->render('AppBundle:equipo:estadisticas_individuales.html.twig',array(
            'form'        => $form->createView(),
            'equipo'      => $equipo,
            'fecha_desde' => $desde->format('Y-m-d'),
            'fecha_hasta' => $hasta->format('Y-m-d')
        ));

    }

}
