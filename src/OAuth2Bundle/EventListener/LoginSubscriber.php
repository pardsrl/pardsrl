<?php
/**
 * Created by PhpStorm.
 * User: santiago
 * Date: 3/10/16
 * Time: 16:51
 */

namespace OAuth2Bundle\EventListener;


use Doctrine\Common\Util\Debug;
use FOS\UserBundle\FOSUserEvents;
use League\OAuth2\Client\Provider\GenericProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class LoginSubscriber implements EventSubscriberInterface  {

	protected $container;

	protected $oauthManager;

	protected $request;

	protected $session;

	public function __construct( ContainerInterface $container ) // this is @service_container
	{

		$this->container = $container;

		$this->request = $this->container->get('request');

		$this->session = $this->container->get('session');

		$this->oauth2Manager = $this->container->get('api.oauth2');

	}

	/**
	 * {@inheritDoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onLogin',
			SecurityEvents::INTERACTIVE_LOGIN => 'onLogin',
		);
	}

	public function onLogin(InteractiveLoginEvent $event)
	{

		$username = $this->request->request->get('_username');

		$password = $this->request->request->get('_password');

		if($this->oauth2Manager->isApiEnabled()){

			$oAuth2Token = $this->oauth2Manager->getAccessToken($username,$password);

			//dump($oAuth2Token);

			$this->session->set('oauth2_token',$oAuth2Token);
		}

		return true;
	}



}