<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EstadisticaController extends Controller
{
    public function operacionesPorEquipoAction()
    {

        $estadisticaManager = $this->get('manager.estadistica');

        $operacionesPorEquipo = $estadisticaManager->getDistribucionOperacionesPorEquipo($this->getUser()->getPersona());

        return $this->render('AppBundle:estadistica:operaciones_por_equipo.html.twig', array(
            'data' => json_encode($operacionesPorEquipo)
        ));
    }

    public function operacionesPorYacimientoAction()
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $operacionesPorEquipo = $estadisticaManager->getDistribucionOperacionesPorYacimiento($this->getUser()->getPersona());

        return $this->render('AppBundle:estadistica:operaciones_por_yacimiento.html.twig', array(
            'data' => json_encode($operacionesPorEquipo)
        ));

    }

    public function promediosCanosHoraAction()
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $promediosCanosHora = $estadisticaManager->getPromediosCanoHora($this->getUser()->getPersona());

        return $this->render('AppBundle:estadistica:promedios_canos_hora.html.twig', array(
            'data' => json_encode($promediosCanosHora)
        ));
    }

    public function factorTiempoUtilAction()
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $factorTiempoUtil = $estadisticaManager->getFactorTiempoUtil($this->getUser()->getPersona());

        return $this->render('AppBundle:estadistica:factor_tiempo_util.html.twig', array(
            'data' => json_encode($factorTiempoUtil)
        ));
    }

    public function promediosVarillasHoraAction()
    {
        $estadisticaManager = $this->get('manager.estadistica');

        $promediosVarillasHora = $estadisticaManager->getPromediosVarillasHora($this->getUser()->getPersona());

        return $this->render('AppBundle:estadistica:promedios_varillas_hora.html.twig', array(
            'data' => json_encode($promediosVarillasHora)
        ));
    }

}
