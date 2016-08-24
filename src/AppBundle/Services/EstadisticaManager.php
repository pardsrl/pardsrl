<?php


namespace AppBundle\Services;

use AppBundle\Entity\Persona;
use Doctrine\ORM\EntityManager;

class EstadisticaManager
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    private function getRangoFechaDefault(){

        $fechaActual = new \DateTime('now');

        $fechaHasta = $fechaActual->format('Y-m-d');

        $fechaDesde = $fechaActual->modify('-1 year')->format('Y-m-d');

        return array('desde'=>$fechaDesde,'hasta'=>$fechaHasta);
    }

    public function getDistribucionOperacionesPorEquipo(Persona $persona){

        $fechas = $this->getRangoFechaDefault();

        $equipos = $persona->getEquiposActivos();

        $distribucionPorEquipoQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getDistribucionOperacionesPorEquipo($equipos,$fechas['desde'],$fechas['hasta']);

        $distribucionPorEquipo = $distribucionPorEquipoQb->getQuery()->getResult();

        $total = 0;

        $data =  array();

        if($distribucionPorEquipo){

            foreach ($distribucionPorEquipo as $distribucion){
                $total = $total + $distribucion['cant'];
            }


            foreach ($distribucionPorEquipo as $distribucion){
                $data[] =  array(
                    'name' => $distribucion['acronimo'].' '.$distribucion['nombre'],
                    'y'    =>($distribucion['cant'] / $total));
            }

        }

        return $data;
    }

    public function getDistribucionOperacionesPorYacimiento(Persona $persona){

        $fechas = $this->getRangoFechaDefault();

        $equipos = $persona->getEquiposActivos();

        $distribucionPorYacimientoQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getDistribucionOperacionesPorYacimiento($equipos,$fechas['desde'],$fechas['hasta']);

        $distribucionPorYacimiento = $distribucionPorYacimientoQb->getQuery()->getResult();

        $total = 0;

        $data =  array();

        if($distribucionPorYacimiento) {

            foreach ($distribucionPorYacimiento as $distribucion) {
                $total = $total + $distribucion['cant'];
            }


            foreach ($distribucionPorYacimiento as $distribucion) {
                $data[] = array(
                    'name' => $distribucion['nombre'],
                    'y' => ($distribucion['cant'] / $total)
                );
            }

        }

        return $data;
    }


    public function getPromediosCanoHora(Persona $persona)
    {
        $fechas = $this->getRangoFechaDefault();

        $equipos = $persona->getEquiposActivos();

        $promediosCanosHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getPromediosCanosHora($equipos,$fechas['desde'],$fechas['hasta']);

        $promediosCanosHora = $promediosCanosHoraQb->getQuery()->getResult();

        $total = 0;

        $data =  array();

        if($promediosCanosHora) {

            foreach ($promediosCanosHora as $promedio) {
                $total = $total + $promedio['promTbg'];
            }

            foreach ($promediosCanosHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['acronimo'] . ' ' . $promedio['nombre'],
                    'y' => ($promedio['promTbg'] / $total) * 100
                );
            }

        }

        return $data;
    }

    public function getPromediosVarillasHora(Persona $persona)
    {
        $fechas = $this->getRangoFechaDefault();

        $equipos = $persona->getEquiposActivos();

        $promediosVarillasHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getPromedioVarillasHora($equipos,$fechas['desde'],$fechas['hasta']);

        $promediosVarillasHora = $promediosVarillasHoraQb->getQuery()->getResult();

        $total = 0;

        $data =  array();

        if($promediosVarillasHora) {

            foreach ($promediosVarillasHora as $promedio) {
                $total = $total + $promedio['promVb'];
            }

            foreach ($promediosVarillasHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['acronimo'] . ' ' . $promedio['nombre'],
                    'y' => ($promedio['promVb'] / $total) * 100
                );
            }

        }

        return $data;
    }

    public function getFactorTiempoUtil(Persona $persona)
    {
        $fechas = $this->getRangoFechaDefault();

        $equipos = $persona->getEquiposActivos();

        $factorTiempoUtilQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getFactorTiempoUtil($equipos,$fechas['desde'],$fechas['hasta']);

        $factorTiempoUtil = $factorTiempoUtilQb->getQuery()->getResult();

        $total = 0;

        $data =  array();

        if($factorTiempoUtil) {

            foreach ($factorTiempoUtil as $promedio) {
                $total = $total + $promedio['ftu'];
            }

            foreach ($factorTiempoUtil as $promedio) {
                $data[] = array(
                    'name' => $promedio['acronimo'] . ' ' . $promedio['nombre'],
                    'y' => ($promedio['ftu'] / $total) * 100
                );
            }

        }

        return $data;
    }
}
