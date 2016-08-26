<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapaController extends Controller
{
    /**
     * Renderiza un mapa con los pozos donde existan intervenciones actuales
     */
    public function pozosAbiertosAction(Request $request)
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

        return $this->render('AppBundle:mapa:pozos_abiertos.html.twig', array(
            'pozo_data' => json_encode($pozosData)
        ));
    }
}
