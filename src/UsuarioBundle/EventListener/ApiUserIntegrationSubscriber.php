<?php
/**
 * Created by PhpStorm.
 * User: santiago
 * Date: 3/10/16
 * Time: 16:51
 */

namespace UsuarioBundle\EventListener;


use AppBundle\Entity\Persona;

use AppBundle\Event\PersonaCreadaEvent;
use AppBundle\Event\PersonaEliminadaEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UsuarioBundle\Entity\OauthUsers;
use UsuarioBundle\Entity\Usuario;
use UsuarioBundle\Event\UsuarioPasswordModificadoEvent;

class ApiUserIntegrationSubscriber implements EventSubscriberInterface {

	protected $container;

	public function __construct( ContainerInterface $container ) // this is @service_container
	{
		$this->container = $container;
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

		if($this->isApiEnabled()){

			$em = $this->container->get('doctrine')->getManager();

			$oauthUser = $this->genOauthUser($persona);

			$em->persist( $oauthUser );
		}


	}


	/**
	 * Elimina el registro del usuario oauth
	 *
	 * @param PersonaEliminadaEvent $event
	 */
	public function onPersonaEliminada( PersonaEliminadaEvent $event ) {

		$persona = $event->getPersona();

		if($this->isApiEnabled()){

			$em = $this->container->get('doctrine')->getManager();

			$oauthUser = $this->getOauthUser($persona->getUsuario()->getUsername());

			$em->remove( $oauthUser );

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

		if($this->isApiEnabled()){

			$em = $this->container->get('doctrine')->getManager();

			$oauthUser = $this->updateOauthPassword($usuario);

			$em->persist( $oauthUser );

		}

	}


	/**
	 *
	 * Genera un oAuthUsuario
	 *
	 * @param Persona $persona
	 *
	 * @return OauthUsers
	 */
	private function genOauthUser(Persona $persona){

		$oauthUser = new OauthUsers();

		$password_bcrypt = $this->bcryptPassword($persona->getUsuario()->getPlainPassword());

		$oauthUser->setFirstName( $persona->getNombre() );

		$oauthUser->setLastName( $persona->getApellido() );

		$oauthUser->setUsername( $persona->getUsuario()->getUsername() );

		$oauthUser->setPassword( $password_bcrypt );

		return $oauthUser;

	}

	/**
	 * Genera un Bcrypt Password
	 *
	 * @param $plainPass
	 *
	 * @return bool|false|string
	 */
	public function bcryptPassword($plainPass){

		$salt = random_bytes( 22 );

		$password_bcrypt = password_hash(
			$plainPass,
			PASSWORD_BCRYPT,
			array( 'salt' => $salt )
		);

		return $password_bcrypt;

	}

	private function updateOauthPassword( Usuario $usuario ) {


		$oAuthUser = $this->getOauthUser($usuario->getPlainPassword());

		$password_bcrypt = $this->bcryptPassword($usuario->getPlainPassword());

		$oAuthUser->setPassword($password_bcrypt);

		return $oAuthUser;

	}

	private function getOauthUser($username){

		$em = $this->container->get('doctrine')->getManager();

		$oautUsersRepository = $em->getRepository('UsuarioBundle:OauthUsers');

		$oAuthUser = $oautUsersRepository->findOneBy(array('username'=> $username));

		return $oAuthUser;
	}


	/**
	 *
	 *
	 * @return bool | Exception
	 */
	private function isApiEnabled(){

		if ( $this->container->hasParameter( 'api' ) ) {

			$api = $this->container->getParameter( 'api' );

			if ( is_array( $api ) && key_exists( 'user_integration', $api ) ) {

				if ( $api['user_integration'] ) {

					return true;

				}
			} else {
				throw new Exception( 'El parámetro user_integration debe estar definido en parameters.yml' );
			}
		}

		return false;
	}
}