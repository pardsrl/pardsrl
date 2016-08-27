<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapaController extends Controller
{
    /**
     * Renderiza un mapa con los pozos donde existan intervenciones actuales
     */
    public function pozosIntervenidosActualmenteAction(Request $request)
    {

        $persona = $this->getUser()->getPersona();

        $misEquipos = $persona->getEquiposActivos();

        $pozosActivos = $this->getDoctrine()->getRepository('AppBundle:Pozo')->findBy(array('activo' => true));

        $pozosData = array();

        if($pozosActivos){

            foreach ($pozosActivos as $pozo){

                if($pozo->estaAbierto()){

                    $ultimaIntervencion = $pozo->getUltimaIntervencion();

                    if($misEquipos->contains($ultimaIntervencion->getEquipo()) ){

                        $equipo = $ultimaIntervencion->getEquipo();

                        $aEquipo = array(
                            'nombre' => $equipo->getNombreCompleto()
                        );

                        $aPozo = array(
                            'acronimo'=> $pozo->getAcronimo(),
                            'lat' => $pozo->getLatitud(),
                            'lng' => $pozo->getLongitud(),
                            'interv' => $pozo->getUltimaIntervencion()->getFecha()->format('d-m-Y H:i:s')
                        );


                        $pozosData[] = array(
                          'equipo' => $aEquipo,
                          'pozo'   => $aPozo
                        );
                    }
                }
            }

        }

        return $this->render('AppBundle:mapa:pozos_intervenidos_actualmente.html.twig', array(
            'pozo_data' => json_encode($pozosData)
        ));
    }

    public function trazadoPozosPorEquipoAction(Request $request, Equipo $equipo)
    {
        $desde = $request->get('desde');

        $hasta = $request->get('hasta');

        $trazadoQb = $this->getDoctrine()->getRepository('AppBundle:EstadisticaFinal')->getTrazadoPozosPorEquipo($equipo,$desde,$hasta);

        $trazado = $trazadoQb->getQuery()->getArrayResult();

        $pozos = array();

        $i = 0;

        foreach ($trazado as $traza){


            if($i == 0){
                $pozos[] = array(
                    'acronimo'        => $traza['pozo_acr'],
                    'lat'             => $traza['pozo_lat'],
                    'lng'             => $traza['pozo_lng'],
                    "intervenciones"  => array($traza['interv_fecha']->format('d-m-Y H:i:s'))
                );
            }else{

                if( in_array($traza['pozo_acr'],$pozos[$i-1])){
                    $pozos[$i-1]["intervenciones"][] =  $traza['interv_fecha']->format('d-m-Y H:i:s');
                }else{
                    $pozos[] = array(
                        'acronimo'        => $traza['pozo_acr'],
                        'lat'             => $traza['pozo_lat'],
                        'lng'             => $traza['pozo_lng'],
                        "intervenciones"  => array($traza['interv_fecha']->format('d-m-Y H:i:s'))
                    );
                }
            }


            $i++;

        }

        return $this->render('AppBundle:mapa:trazado_pozos_equipo.html.twig', array(
            'pozos' => json_encode($pozos)
        ));

    }



}
