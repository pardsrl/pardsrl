<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EstadisticaController extends Controller
{
    public function operacionesPorEquipoAction(Request $request )
    {

        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $operacionesPorEquipo = $estadisticaManager->getDistribucionOperacionesPorEquipo($this->getUser()->getPersona(),$desde,$hasta);

        return $this->render('AppBundle:estadistica:operaciones_por_equipo.html.twig', array(
            'data' => json_encode($operacionesPorEquipo)
        ));
    }

    public function operacionesPorYacimientoAction(Request $request)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $operacionesPorEquipo = $estadisticaManager->getDistribucionOperacionesPorYacimiento($this->getUser()->getPersona(),$desde,$hasta);

        return $this->render('AppBundle:estadistica:operaciones_por_yacimiento.html.twig', array(
            'data' => json_encode($operacionesPorEquipo)
        ));

    }

    public function promediosCanosHoraAction(Request $request)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $promediosCanosHora = $estadisticaManager->getPromediosCanoHora($this->getUser()->getPersona(),$desde,$hasta);

        return $this->render('AppBundle:estadistica:promedios_canos_hora.html.twig', array(
            'data' => json_encode($promediosCanosHora)
        ));
    }

    public function factorTiempoUtilAction(Request $request)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $factorTiempoUtil = $estadisticaManager->getFactorTiempoUtil($this->getUser()->getPersona(),$desde,$hasta);

        return $this->render('AppBundle:estadistica:factor_tiempo_util.html.twig', array(
            'data' => json_encode($factorTiempoUtil)
        ));
    }

    public function promediosVarillasHoraAction(Request $request)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $promediosVarillasHora = $estadisticaManager->getPromediosVarillasHora($this->getUser()->getPersona(),$desde,$hasta);

        return $this->render('AppBundle:estadistica:promedios_varillas_hora.html.twig', array(
            'data' => json_encode($promediosVarillasHora)
        ));
    }


    public function operacionesIndividualesPorYacimientoAction(Request $request, Equipo $equipo)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $promediosVarillasHora = $estadisticaManager->getDistribucionOperacionesIndividualesPorYacimiento($equipo,$desde,$hasta);

        return $this->render('AppBundle:estadistica:operaciones_individuales_yaciemiento.html.twig', array(
            'data' => json_encode($promediosVarillasHora)
        ));
    }


    public function promediosIndividualesCanosHoraAction(Request $request, Equipo $equipo)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $promediosCanosHora = $estadisticaManager->getPromediosIndividualesCanoHora($equipo,$desde,$hasta);

        return $this->render('AppBundle:estadistica:promedios_individuales_canos_hora.html.twig', array(
            'data'   => json_encode($promediosCanosHora),
            'equipo' => $equipo,
	        'fdesde'  => strtotime($desde)*1000,
	        'fhasta'  => strtotime($hasta)*1000
        ));
    }

    public function promediosIndividualesVarillasHoraAction(Request $request, Equipo $equipo)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $promediosCanosHora = $estadisticaManager->getPromediosIndividualesVarillasHora($equipo,$desde,$hasta);

        return $this->render('AppBundle:estadistica:promedios_individuales_varillas_hora.html.twig', array(
            'data' => json_encode($promediosCanosHora),
            'equipo' => $equipo,
            'fdesde'  => strtotime($desde)*1000,
            'fhasta'  => strtotime($hasta)*1000
        ));
    }

    public function individualesFactorTiempoUtilAction(Request $request, Equipo $equipo)
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $factorTiempoUtil = $estadisticaManager->getIndividualesFactorTiempoUtil($equipo,$desde,$hasta);

        return $this->render('AppBundle:estadistica:individuales_factor_tiempo_util.html.twig', array(
            'data' => json_encode($factorTiempoUtil),
            'equipo' => $equipo,
            'fdesde'  => strtotime($desde)*1000,
            'fhasta'  => strtotime($hasta)*1000
        ));
    }

}
