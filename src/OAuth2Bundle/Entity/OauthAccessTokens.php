<?php

namespace OAuth2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthUsers
 *
 * @ORM\Table(name="oauth_access_tokens")
 * @ORM\Entity()
 */
class OauthAccessTokens
{


    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="access_token", type="string", length=40, unique=true)
     */
    private $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=80)
     */
    private $client;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_id", type="string", length=255, nullable=true)
	 */
	private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="expires", type="datetime")
     */
    private $expires;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="scope", type="string", length=20000, nullable=true)
	 */
	private $scope;



    /**
     * Set accessToken
     *
     * @param string $accessToken
     *
     * @return OauthAccessTokens
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set client
     *
     * @param string $client
     *
     * @return OauthAccessTokens
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return OauthAccessTokens
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     *
     * @return OauthAccessTokens
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set scope
     *
     * @param string $scope
     *
     * @return OauthAccessTokens
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }


    public function isExpired(){

    	$now = new \DateTime('NOW');

    	if($this->getExpires() < $now){
    		return false;
	    }

	    return true;
    }

    public function __toString() {
		return $this->getAccessToken();
    }
}
