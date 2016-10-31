<?php

namespace OAuth2Bundle\Controller;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function refreshTokenAction(Request $request)
    {

    	//por el momento hasta que se desee implementar el refresco de tokens oauth
    	return $this->createNotFoundException();

    	$oauth2Manager = $this->get('api.oauth2');

	    if($oauth2Manager->isApiEnabled()){

		    $session = $request->getSession();

		    $oauthTokenSess = $session->get('oauth2_token');

		    //var_dump($oauthTokenSess);

		    if($oauthTokenSess){

		        $oauthTokenSess = json_decode($oauthTokenSess,true);

			    if($oauthTokenSess && $oauthTokenSess['access_token']){

				    $accessToken = new AccessToken(array(
					    'access_token' => $oauthTokenSess['access_token'],
			            'refresh_token'=> $oauthTokenSess['refresh_token'],
			            'expires'      => $oauthTokenSess['expires']
				    ));

				    if ( $accessToken->hasExpired() ){

					    $api = $this->container->getParameter( 'api' );

					    $access_token_url = $api['url'].$api['auth_login_endpoint'];

					    $provider = new GenericProvider([
						    'clientId'                => $api['auth_client_id'],    // The client ID assigned to you by the provider
						    'clientSecret'            => $api['auth_client_secret'],   // The client password assigned to you by the provider
						    'urlAccessToken'          => $access_token_url,
						    'urlResourceOwnerDetails' => '',
						    'urlAuthorize'            => ''
					    ]);

					    $newAccessToken = $provider->getAccessToken('refresh_token', [
						    'refresh_token' => $accessToken->getRefreshToken()
					    ]);

					    //reeamplazo el array de session con los nuevos valores
					    $jsonAccessToken = json_encode(array_replace($oauthTokenSess,$newAccessToken->jsonSerialize()));

					    $session->set('oauth2_token',$jsonAccessToken);

					    return new JsonResponse($newAccessToken->jsonSerialize());

				    }

			    }

		    }


	    }

	    return new JsonResponse(array(
		    'access_token'  => null,
		    'error_message' => 'No se pude generar un token nuevo'
	    ));


    }
}
