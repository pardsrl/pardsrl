<?php

namespace OAuth2Bundle\EventListener;

use OAuth2Bundle\Services\OAuth2Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutListener implements LogoutSuccessHandlerInterface  {

	protected $oauth2Manager;

	protected $logoutTarget;

	protected $httpUtils;

	public function __construct(OAuth2Manager $OAuth2Manager , HttpUtils $httpUtils ,$logoutTarget) // this is @OAuth2Manager
	{

		$this->oauth2Manager = $OAuth2Manager;

		$this->logoutTarget = $logoutTarget;

		$this->httpUtils = $httpUtils;

	}


	public function onLogoutSuccess(Request $request){

		if($this->oauth2Manager->isApiEnabled()){

			$session = $request->getSession();

			$oauth2Token = json_decode($session->get('oauth2_token'),true);

			$accessToken = $oauth2Token['access_token'];

			$this->oauth2Manager->deleteAccessToken($accessToken);

		}


		return $this->httpUtils->createRedirectResponse($request, $this->logoutTarget);
	}


}