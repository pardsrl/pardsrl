<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * MensajeEstado
 *
 * @ORM\Table(name="mensaje_estado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MensajeEstadoRepository")
 */
class MensajeEstado extends BaseClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="leido", type="boolean")
     */
    private $leido = false;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mensaje", inversedBy="estados")
     * @ORM\JoinColumn(name="mensaje_id", referencedColumnName="id")
     */
    private $mensaje;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    private $persona;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return MensajeEstado
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set mensaje
     *
     * @param \AppBundle\Entity\Mensaje $mensaje
     *
     * @return MensajeEstado
     */
    public function setMensaje(\AppBundle\Entity\Mensaje $mensaje = null)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return \AppBundle\Entity\Mensaje
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return MensajeEstado
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
