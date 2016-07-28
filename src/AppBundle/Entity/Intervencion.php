<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Intervencion
 *
 * @ORM\Table(name="intervencion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IntervencionRepository")
 */
class Intervencion extends BaseClass
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var bool
     *
     * @ORM\Column(name="accion", type="boolean")
     */
    private $accion;


    /**
     * @var $equipo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipo", inversedBy="intervenciones")
     * @ORM\JoinColumn(name="equipo_id", referencedColumnName="id", nullable=false)
     */
    private $equipo;

    /**
     * @var $pozo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pozo", inversedBy="intervenciones")
     * @ORM\JoinColumn(name="pozo_id", referencedColumnName="id", nullable=false)
     */
    private $pozo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Novedad", mappedBy="intervencion")
     */
    private $novedades;


    public function __toString()
    {
        return (string) $this->getId();
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Intervencion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set accion
     *
     * @param boolean $accion
     *
     * @return Intervencion
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return bool
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     *
     * @return Intervencion
     */
    public function setEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipo = $equipo;

        return $this;
    }

    /**
     * Get equipo
     *
     * @return \AppBundle\Entity\Equipo
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * Set pozo
     *
     * @param \AppBundle\Entity\Pozo $pozo
     *
     * @return Intervencion
     */
    public function setPozo(\AppBundle\Entity\Pozo $pozo)
    {
        $this->pozo = $pozo;

        return $this;
    }

    /**
     * Get pozo
     *
     * @return \AppBundle\Entity\Pozo
     */
    public function getPozo()
    {
        return $this->pozo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->novedades = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add novedade
     *
     * @param \AppBundle\Entity\Novedad $novedade
     *
     * @return Intervencion
     */
    public function addNovedad(\AppBundle\Entity\Novedad $novedad)
    {
        $this->novedades[] = $novedad;

        return $this;
    }

    /**
     * Remove novedade
     *
     * @param \AppBundle\Entity\Novedad $novedad
     */
    public function removeNovedad(\AppBundle\Entity\Novedad $novedad)
    {
        $this->novedades->removeElement($novedad);
    }

    /**
     * Get novedades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNovedades()
    {
        return $this->novedades;
    }


    public function esApertura()
    {
        if($this->getAccion() == 0 )
            return true;

        return false;
    }


    public function esCierre()
    {
        if($this->getAccion() == 1)
            return true;

        return false;
    }
}
