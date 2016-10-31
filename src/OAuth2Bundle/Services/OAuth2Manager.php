<?php


namespace OAuth2Bundle\Services;


use AppBundle\Entity\Persona;
use League\OAuth2\Client\Provider\GenericProvider;
use OAuth2Bundle\Entity\OauthUsers;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UsuarioBundle\Entity\Usuario;

class OAuth2Manager
{

    private $container;

    private $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

	    $this->em = $this->container->get('doctrine')->getManager();

    }


	/**
	 * Chequea que el parametro enabled esté definido y en true
	 *
	 * @return bool | Exception
	 */
	public function isApiEnabled(){

		if ( $this->container->hasParameter( 'api' ) ) {

			$api = $this->container->getParameter( 'api' );

			if ( is_array( $api ) && key_exists( 'enabled', $api ) ) {

				if ( $api['enabled'] ) {

					return true;

				}
			} else {
				throw new \Exception( 'El parámetro enabled debe estar definido en parameters.yml' );
			}
		}

		return false;
	}

	/**
	 *
	 * Chequea que el parametro user_integration esté definido y en true
	 *
	 * @return bool | Exception
	 */
	public function isUserIntegrationEnabled(){

		if ( $this->container->hasParameter( 'api' ) ) {

			$api = $this->container->getParameter( 'api' );

			if ( is_array( $api ) && key_exists( 'user_integration', $api ) ) {

				if ( $api['user_integration'] ) {

					return true;

				}
			} else {
				throw new \Exception( 'El parámetro user_integration debe estar definido en parameters.yml' );
			}
		}

		return false;
	}

	public function getAccessToken($username,$password){

		$api = $this->container->getParameter( 'api' );

		$accessToken = null;

		$access_token_url = $api['url'].$api['auth_login_endpoint'];

		$provider = new GenericProvider([
			'clientId'                => $api['auth_client_id'],    // The client ID assigned to you by the provider
			'clientSecret'            => $api['auth_client_secret'],   // The client password assigned to you by the provider
			'urlAccessToken'          => $access_token_url,
			'urlResourceOwnerDetails' => '',
			'urlAuthorize'            => ''
		]);

		try {

			// Try to get an access token using the resource owner password credentials grant.
			$accessToken = $provider->getAccessToken('password', [
				'username' => $username,
				'password' => $password
			]);

			$jsonAccessToken = json_encode($accessToken);

			return $jsonAccessToken;

		} catch (\Exception $e) {

			$mensaje = $e->getMessage();

			$accessToken = array(
				'access_token'  => null,
				'error_message' => $mensaje
			);

			return json_encode($accessToken);

		}

	}


	public function deleteAccessToken($token){

		$oAuthToken = $this->getToken($token);

		if($oAuthToken){

			$this->em->remove($oAuthToken);

			$this->em->flush();
		}

	}

	/**
	 * Delete tokens by username
	 *
	 * @param $username
	 */
	public function deleteAccessTokenByUsername($username){

		$tokens = $this->getTokensByUsername($username);

		foreach ( $tokens as $oauthToken ) {
			$this->em->remove($oauthToken);
		}

		$this->em->flush();

	}

	/**
	 * Delete oauth2user
	 *
	 * @param $username
	 */
	public function deleteOauth2User($username){

		$oauthUser = $this->getOauthUser($username);

		$this->deleteAccessTokenByUsername($username);

		$this->em->remove( $oauthUser );

		$this->em->flush();
	}

	/**
	 *
	 * Genera un oAuthUsuario
	 *
	 * @param Persona $persona
	 *
	 * @return OauthUsers
	 */
	public function genOauthUser(Persona $persona){

		$oAuthUser = new OauthUsers();

		$password_bcrypt = $this->bcryptPassword($persona->getUsuario()->getPlainPassword());

		$oAuthUser->setFirstName( $persona->getNombre() );

		$oAuthUser->setLastName( $persona->getApellido() );

		$oAuthUser->setUsername( $persona->getUsuario()->getUsername() );

		$oAuthUser->setPassword( $password_bcrypt );

		$this->em->persist( $oAuthUser );

		return $oAuthUser;

	}

	/**
	 * Genera un Bcrypt Password
	 *
	 * @param $plainPass
	 *
	 * @return bool|false|string
	 */
	private function bcryptPassword($plainPass){

		$salt = random_bytes( 22 );

		$password_bcrypt = password_hash(
			$plainPass,
			PASSWORD_BCRYPT,
			array( 'salt' => $salt )
		);

		return $password_bcrypt;

	}

	public function updateOauthPassword( Usuario $usuario ) {

		$oAuthUser = $this->getOauthUser($usuario->getUsername());

		//si existe el usuario actualizo el pass sino lo creo
		if($oAuthUser){

			$password_bcrypt = $this->bcryptPassword($usuario->getPlainPassword());

			$oAuthUser->setPassword($password_bcrypt);

			$this->em->persist( $oAuthUser );

		}else{

			$oAuthUser = $this->genOauthUser($usuario->getPersona());

		}

		return $oAuthUser;

	}

	public function getOauthUser($username){

		$oautUsersRepository = $this->em->getRepository('OAuth2Bundle:OauthUsers');

		$oAuthUser = $oautUsersRepository->findOneBy(array('username'=> $username));

		return $oAuthUser;
	}

	private function getTokensByUsername($username){

		$oauthTokens = $this->em->getRepository('OAuth2Bundle:OauthAccessTokens')->findBy(array('user'=>$username));

		return $oauthTokens;

	}

	private function getToken($token){

		$oauthTokens = $this->em->getRepository('OAuth2Bundle:OauthAccessTokens')->findOneBy(array('accessToken'=>$token));

		return $oauthTokens;

	}

}
