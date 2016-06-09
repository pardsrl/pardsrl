<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacion
 *
 * @ORM\Table(name="notificacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificacionRepository")
 */
class Notificacion extends BaseClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="notificacion", type="string", length=255)
     */
    private $notificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="prioridad", type="integer")
     */
    private $prioridad;

    /**
     * @var bool
     *
     * @ORM\Column(name="sistema", type="boolean", nullable=true)
     */
    private $sistema;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\NotificacionDistribucion", mappedBy="notificacion")
     */
    private $distribucion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\NotificacionEstado", mappedBy="notificacion")
     */
    private $estados;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estados = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set notificacion
     *
     * @param string $notificacion
     *
     * @return Notificacion
     */
    public function setNotificacion($notificacion)
    {
        $this->notificacion = $notificacion;

        return $this;
    }

    /**
     * Get notificacion
     *
     * @return string
     */
    public function getNotificacion()
    {
        return $this->notificacion;
    }

    /**
     * Set prioridad
     *
     * @param integer $prioridad
     *
     * @return Notificacion
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return integer
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set sistema
     *
     * @param boolean $sistema
     *
     * @return Notificacion
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;

        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }


    /**
     * Set distribucion
     *
     * @param \AppBundle\Entity\NotificacionDistribucion $distribucion
     *
     * @return Notificacion
     */
    public function setDistribucion(\AppBundle\Entity\NotificacionDistribucion $distribucion = null)
    {
        $this->distribucion = $distribucion;

        return $this;
    }

    /**
     * Get distribucion
     *
     * @return \AppBundle\Entity\NotificacionDistribucion
     */
    public function getDistribucion()
    {
        return $this->distribucion;
    }

    /**
     * Add estado
     *
     * @param \AppBundle\Entity\NotificacionEstado $estado
     *
     * @return Notificacion
     */
    public function addEstado(\AppBundle\Entity\NotificacionEstado $estado)
    {
        $this->estados[] = $estado;

        return $this;
    }

    /**
     * Remove estado
     *
     * @param \AppBundle\Entity\NotificacionEstado $estado
     */
    public function removeEstado(\AppBundle\Entity\NotificacionEstado $estado)
    {
        $this->estados->removeElement($estado);
    }

    /**
     * Get estados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstados()
    {
        return $this->estados;
    }
    
}
