<?php
// src/AppBundle/Entity/User.php

namespace UsuarioBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="UsuarioBundle\Repository\UsuarioRepository")
 * @UniqueEntity("email",errorPath="email",groups={"Registracion"})
 * @UniqueEntity("username",errorPath="username",groups={"Registracion"})
 * @ORM\Table(name="fos_user")
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $persona
     * 
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Persona", mappedBy="usuario")
     */
    protected $persona;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return Usuario
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }
}
