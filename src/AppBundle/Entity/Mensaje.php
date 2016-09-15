<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mensaje
 *
 * @ORM\Table(name="mensaje")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MensajeRepository")
 */
class Mensaje extends BaseClass
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
     * @var string
     *
     * @ORM\Column(name="mensaje", type="text")
     */
    private $mensaje;

    /**
     * @var int
     *
     * @ORM\Column(name="destacado", type="boolean", nullable=true)
     */
    private $destacado = false;

    /**
     * @var int
     *
     * @ORM\Column(name="archivado", type="boolean", nullable=true)
     */
    private $archivado = false;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MensajeDistribucion", mappedBy="mensaje")
     */
    private $distribucion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MensajeEstado", mappedBy="mensaje")
     */
    private $estados;

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
     * Constructor
     */
    public function __construct()
    {
        $this->estados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     *
     * @return Mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set destacado
     *
     * @param boolean $destacado
     *
     * @return Mensaje
     */
    public function setDestacado($destacado)
    {
        $this->destacado = $destacado;

        return $this;
    }

    /**
     * Get destacado
     *
     * @return boolean
     */
    public function getDestacado()
    {
        return $this->destacado;
    }

    /**
     * Set archivado
     *
     * @param boolean $archivado
     *
     * @return Mensaje
     */
    public function setArchivado($archivado)
    {
        $this->archivado = $archivado;

        return $this;
    }

    /**
     * Get archivado
     *
     * @return boolean
     */
    public function getArchivado()
    {
        return $this->archivado;
    }

    /**
     * Set distribucion
     *
     * @param \AppBundle\Entity\MensajeDistribucion $distribucion
     *
     * @return Mensaje
     */
    public function setDistribucion(\AppBundle\Entity\MensajeDistribucion $distribucion = null)
    {
        $this->distribucion = $distribucion;

        return $this;
    }

    /**
     * Get distribucion
     *
     * @return \AppBundle\Entity\MensajeDistribucion
     */
    public function getDistribucion()
    {
        return $this->distribucion;
    }

    /**
     * Add estado
     *
     * @param \AppBundle\Entity\MensajeEstado $estado
     *
     * @return Mensaje
     */
    public function addEstado(\AppBundle\Entity\MensajeEstado $estado)
    {
        $this->estados[] = $estado;

        return $this;
    }

    /**
     * Remove estado
     *
     * @param \AppBundle\Entity\MensajeEstado $estado
     */
    public function removeEstado(\AppBundle\Entity\MensajeEstado $estado)
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
