<?php


namespace AppBundle\Services;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ConfigManager
{
	private $tokenStorage;

	public function __construct(TokenStorage $tokenStorage) {

		$this->tokenStorage = $tokenStorage->getToken();

	}


	public function getVars(){

		$vars = array();

		if($this->tokenStorage) {

			$persona = $this->tokenStorage->getUser()->getPersona();

			$configuracionPersonal = $persona->getConfiguracion();

			$vars = array(
				'graficas' => array(
					'historicoPozo'       => array(
						'enabled' => ( $configuracionPersonal == null || $configuracionPersonal->getConfig( 'historicoPozo' ) == true ) ? true : false,
						'col'     => 12
					),
					'historicoManiobras'  => array(
						'enabled' => ( $configuracionPersonal == null || $configuracionPersonal->getConfig( 'historicoManiobras' ) == true ) ? true : false,
						'col'     => 12
					),
					'tiempoRealPozo'      => array(
						'enabled' => ( $configuracionPersonal == null || $configuracionPersonal->getConfig( 'tiempoRealPozo' ) == true ) ? true : false,
						'col'     => ( $configuracionPersonal == null || $configuracionPersonal->getConfig( 'tiempoRealManiobras' ) == true ) ? 6 : 12
					),
					'tiempoRealManiobras' => array(
						'enabled' => ( $configuracionPersonal == null || $configuracionPersonal->getConfig( 'tiempoRealManiobras' ) == true ) ? true : false,
						'col'     => ( $configuracionPersonal == null || $configuracionPersonal->getConfig( 'tiempoRealPozo' ) == true ) ? 6 : 12
					)
				)
			);

		}

		return $vars;

	}

}
