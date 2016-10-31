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


//	/**
//	 *
//	 * Genera un oAuthUsuario
//	 *
//	 * @param Persona $persona
//	 *
//	 * @return OauthUsers
//	 */
//	private function genOauthUser(Persona $persona){
//
//		$oauthUser = new OauthUsers();
//
//		$oauth2Manager = $this->container->get('api.oauth2');
//
//		$password_bcrypt = $this->bcryptPassword($persona->getUsuario()->getPlainPassword());
//
//		$oauthUser->setFirstName( $persona->getNombre() );
//
//		$oauthUser->setLastName( $persona->getApellido() );
//
//		$oauthUser->setUsername( $persona->getUsuario()->getUsername() );
//
//		$oauthUser->setPassword( $password_bcrypt );
//
//		return $oauthUser;
//
//	}
//
//	/**
//	 * Genera un Bcrypt Password
//	 *
//	 * @param $plainPass
//	 *
//	 * @return bool|false|string
//	 */
//	public function bcryptPassword($plainPass){
//
//		$salt = random_bytes( 22 );
//
//		$password_bcrypt = password_hash(
//			$plainPass,
//			PASSWORD_BCRYPT,
//			array( 'salt' => $salt )
//		);
//
//		return $password_bcrypt;
//
//	}
//
//	private function updateOauthPassword( Usuario $usuario ) {
//
//
//		$oAuthUser = $this->getOauthUser($usuario->getUsername());
//
//		//si existe el usuario actualizo el pass sino lo creo
//		if($oAuthUser){
//			$password_bcrypt = $this->bcryptPassword($usuario->getPlainPassword());
//
//			$oAuthUser->setPassword($password_bcrypt);
//		}else{
//			$oAuthUser = $this->genOauthUser($usuario->getPersona());
//		}
//
//		return $oAuthUser;
//
//	}
//
//	private function getOauthUser($username){
//
//		$em = $this->container->get('doctrine')->getManager();
//
//		$oautUsersRepository = $em->getRepository('OAuth2Bundle:OauthUsers');
//
//		$oAuthUser = $oautUsersRepository->findOneBy(array('username'=> $username));
//
//		return $oAuthUser;
//	}
//
//
//	/**
//	 *
//	 * Chequea que el parametro user_integration esté definido y en true
//	 *
//	 * @return bool | Exception
//	 */
//	private function isApiEnabled(){
//
//		if ( $this->container->hasParameter( 'api' ) ) {
//
//			$api = $this->container->getParameter( 'api' );
//
//			if ( is_array( $api ) && key_exists( 'user_integration', $api ) ) {
//
//				if ( $api['user_integration'] ) {
//
//					return true;
//
//				}
//			} else {
//				throw new \Exception( 'El parámetro user_integration debe estar definido en parameters.yml' );
//			}
//		}
//
//		return false;
//	}
}