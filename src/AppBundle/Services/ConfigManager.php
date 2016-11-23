<?php


namespace AppBundle\Services;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ConfigManager
{
	private $persona;

	public function __construct(TokenStorage $tokenStorage) {

		$this->persona = $tokenStorage->getToken()->getUser()->getPersona();

	}


	public function getVars(){

		$configuracionPersonal = $this->persona->getConfiguracion();

		$vars = array(
			'graficas' => array(
				'historicoPozo' => array(
					'enabled'  => ($configuracionPersonal == null || $configuracionPersonal->getConfig('historicoPozo') == true) ? true : false,
					'col'      => 12
				),
				'historicoManiobras' => array(
					'enabled'  => ($configuracionPersonal == null || $configuracionPersonal->getConfig('historicoManiobras') == true) ? true : false,
					'col'      => 12
				),
				'tiempoRealPozo' => array(
					'enabled'  => ($configuracionPersonal == null || $configuracionPersonal->getConfig('tiempoRealPozo') == true) ? true : false,
					'col'      => ($configuracionPersonal == null || $configuracionPersonal->getConfig('tiempoRealManiobras') == true) ? 6 : 12
				),
				'tiempoRealManiobras' => array(
					'enabled'  => ($configuracionPersonal == null || $configuracionPersonal->getConfig('tiempoRealManiobras') == true) ? true : false,
					'col'      => ($configuracionPersonal == null || $configuracionPersonal->getConfig('tiempoRealPozo') == true) ? 6 : 12
				)
			)
		);

		return $vars;

	}

}
