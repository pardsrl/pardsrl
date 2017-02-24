<?php
/**
 * Created by PhpStorm.
 * User: santiago
 * Date: 3/10/16
 * Time: 16:51
 */

namespace OAuth2Bundle\EventListener;



use AppBundle\Event\PersonaCreadaEvent;
use AppBundle\Event\PersonaEliminadaEvent;
use OAuth2Bundle\Services\OAuth2Manager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UsuarioBundle\Event\UsuarioPasswordModificadoEvent;

class ApiUserIntegrationSubscriber implements EventSubscriberInterface {


	protected $oauth2Manager;

	public function __construct( OAuth2Manager $OAuth2Manager ) // this is @service_container
	{

		$this->oauth2Manager = $OAuth2Manager;

	}

	public static function getSubscribedEvents() {
		return array(
			PersonaCreadaEvent::NAME => 'onPersonaCreada',
			PersonaEliminadaEvent::NAME => 'onPersonaEliminada',
			UsuarioPasswordModificadoEvent::NAME => 'onUsuarioPasswordModificado',
		);
	}


	/**
	 *
	 * Da de alta un nuevo registro de usuario oauth.
	 *
	 * @param PersonaCreadaEvent $event
	 */
	public function onPersonaCreada( PersonaCreadaEvent $event ) {

		$persona = $event->getPersona();

		if($this->oauth2Manager->isUserIntegrationEnabled()){

			$this->oauth2Manager->genOauthUser($persona);

		}


	}


	/**
	 * Elimina el registro del usuario oauth
	 *
	 * @param PersonaEliminadaEvent $event
	 */
	public function onPersonaEliminada( PersonaEliminadaEvent $event ) {

		$persona = $event->getPersona();

		if($this->oauth2Manager->isUserIntegrationEnabled()){

			$this->oauth2Manager->deleteOauth2User($persona->getUsuario()->getUsername());

		}

	}


	/**
	 *
	 * Modifica el password bcrypt en la api
	 *
	 * @param UsuarioPasswordModificadoEvent $event
	 */
	public function onUsuarioPasswordModificado( UsuarioPasswordModificadoEvent $event ) {

		$usuario = $event->getUsuario();


		if($this->oauth2Manager->isUserIntegrationEnabled()){

			$this->oauth2Manager->updateOauthPassword($usuario);

		}

	}

}