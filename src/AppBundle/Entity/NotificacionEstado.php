<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * NotificacionEstado
 *
 * @ORM\Table(name="notificacion_estado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificacionEstadoRepository")
 */
class NotificacionEstado extends BaseClass
{

    /**
     * @var bool
     *
     * @ORM\Column(name="leido", type="boolean")
     */
    private $leido = false;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Notificacion", inversedBy="estados")
     * @ORM\JoinColumn(name="notificacion_id", referencedColumnName="id")
     */
    private $notificacion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    private $persona;


    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return NotificacionEstado
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
     * Set notificacion
     *
     * @param \AppBundle\Entity\Notificacion $notificacion
     *
     * @return NotificacionEstado
     */
    public function setNotificacion(\AppBundle\Entity\Notificacion $notificacion = null)
    {
        $this->notificacion = $notificacion;

        return $this;
    }

    /**
     * Get notificacion
     *
     * @return \AppBundle\Entity\Notificacion
     */
    public function getNotificacion()
    {
        return $this->notificacion;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return NotificacionEstado
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
