<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReporteController extends Controller
{

	public function indexAction(Request $request)
	{

		return $this->render('AppBundle:reporte:index.html.twig', array(

		));
	}
}
