<?php

namespace AppBundle\Controller;

use AppBundle\Form\EstadisticaGeneralFechaFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {

        $desde = new \DateTime('now');

        $desde = $desde->modify('-1 year');

        $hasta = new \DateTime('now');

        $rangoFechas = array(
            'desde' => $desde,
            'hasta' => $hasta
        );

        $form = $this->createForm(EstadisticaGeneralFechaFilterType::class,$rangoFechas, array(
            'method'        => 'GET'
        ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $desde = $data['desde'];

            $hasta = $data['hasta'];
        }

        return $this->render('AppBundle::index.html.twig',array(
            'form' => $form->createView(),
            'fecha_desde' => $desde->format('Y-m-d'),
            'fecha_hasta' => $hasta->format('Y-m-d')
        ));

    }

}
