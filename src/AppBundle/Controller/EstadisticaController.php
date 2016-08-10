<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EstadisticaController extends Controller
{
    public function operacionesPorEquipoAction()
    {
        return $this->render('AppBundle:estadistica:operaciones_por_equipo.html.twig', array(
            // ...
        ));
    }

    public function operacionesPorYacimientoAction()
    {
        return $this->render('AppBundle:estadistica:operaciones_por_yacimiento.html.twig', array(
            // ...
        ));
    }

    public function promediosCanosHoraAction()
    {
        return $this->render('AppBundle:estadistica:promedios_canos_hora.html.twig', array(
            // ...
        ));
    }

    public function factorTiempoUtilAction()
    {
        return $this->render('AppBundle:estadistica:factor_tiempo_util.html.twig', array(
            // ...
        ));
    }

}
