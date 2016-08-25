<?php


namespace AppBundle\Services;

use AppBundle\Entity\Equipo;
use AppBundle\Entity\Persona;
use Doctrine\ORM\EntityManager;

class EstadisticaManager
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getDistribucionOperacionesPorEquipo(Persona $persona,$desde,$hasta){

        $equipos = $persona->getEquiposActivos();

        $distribucionPorEquipoQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getDistribucionOperacionesPorEquipo($equipos,$desde,$hasta);

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

    public function getDistribucionOperacionesPorYacimiento(Persona $persona,$desde,$hasta){

        $equipos = $persona->getEquiposActivos();

        $distribucionPorYacimientoQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getDistribucionOperacionesPorYacimiento($equipos,$desde,$hasta);

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


    public function getPromediosCanoHora(Persona $persona,$desde,$hasta)
    {
        $equipos = $persona->getEquiposActivos();

        $promediosCanosHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getPromediosCanosHora($equipos,$desde,$hasta);

        $promediosCanosHora = $promediosCanosHoraQb->getQuery()->getResult();

        $data =  array();

        if($promediosCanosHora) {

            foreach ($promediosCanosHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['acronimo'] . ' ' . $promedio['nombre'],
                    'y'    => floatval($promedio['promTbg'])
                );
            }

        }

        return $data;
    }

    public function getPromediosVarillasHora(Persona $persona,$desde,$hasta)
    {
        $equipos = $persona->getEquiposActivos();

        $promediosVarillasHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getPromedioVarillasHora($equipos,$desde,$hasta);

        $promediosVarillasHora = $promediosVarillasHoraQb->getQuery()->getResult();

        $data =  array();

        if($promediosVarillasHora) {


            foreach ($promediosVarillasHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['acronimo'] . ' ' . $promedio['nombre'],
                    'y'    => floatval($promedio['promVb'])
                );
            }

        }

        return $data;
    }

    public function getFactorTiempoUtil(Persona $persona,$desde,$hasta)
    {
        $equipos = $persona->getEquiposActivos();

        $factorTiempoUtilQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getFactorTiempoUtil($equipos,$desde,$hasta);

        $factorTiempoUtil = $factorTiempoUtilQb->getQuery()->getResult();

        $data =  array();

        if($factorTiempoUtil) {

            foreach ($factorTiempoUtil as $promedio) {
                $data[] = array(
                    'name' => $promedio['acronimo'] . ' ' . $promedio['nombre'],
                    'y'    => floatval($promedio['ftu'])
                );
            }

        }

        return $data;
    }

    public function getDistribucionOperacionesIndividualesPorYacimiento(Equipo $equipo,$desde,$hasta){

        $distribucionPorYacimientoQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getDistribucionOperacionesIndividualesPorYacimiento($equipo,$desde,$hasta);

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

    public function getPromediosIndividualesCanoHora(Equipo $equipo,$desde,$hasta)
    {

        $promediosCanosHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getPromediosIndividualesCanosHora($equipo,$desde,$hasta);

        $promediosCanosHora = $promediosCanosHoraQb->getQuery()->getResult();

        $data =  array();

        if($promediosCanosHora) {

            foreach ($promediosCanosHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['fecha']->format('d-m-Y') . ' ' . $promedio['nombre'],
                    'y'    => floatval($promedio['promTbg'])
                );
            }

        }

        return $data;
    }

    public function getPromediosIndividualesVarillasHora(Equipo $equipo,$desde,$hasta)
    {

        $promediosCanosHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getPromediosIndividualesVarillasHora($equipo,$desde,$hasta);

        $promediosCanosHora = $promediosCanosHoraQb->getQuery()->getResult();

        $data =  array();

        if($promediosCanosHora) {

            foreach ($promediosCanosHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['fecha']->format('d-m-Y') . ' ' . $promedio['nombre'],
                    'y'    => floatval($promedio['promVb'])
                );
            }

        }

        return $data;
    }


    public function getIndividualesFactorTiempoUtil(Equipo $equipo,$desde,$hasta)
    {

        $promediosCanosHoraQb = $this->em
            ->getRepository('AppBundle:EstadisticaFinal')
            ->getIndividualesFactorTiempoUtil($equipo,$desde,$hasta);

        $promediosCanosHora = $promediosCanosHoraQb->getQuery()->getResult();

        $data =  array();

        if($promediosCanosHora) {

            foreach ($promediosCanosHora as $promedio) {
                $data[] = array(
                    'name' => $promedio['fecha']->format('d-m-Y') . ' ' . $promedio['nombre'],
                    'y'    => floatval($promedio['ftu'])
                );
            }

        }

        return $data;
    }

}
