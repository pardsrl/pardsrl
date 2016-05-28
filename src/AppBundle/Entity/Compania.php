<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Compania
 *
 * @ORM\Table(name="compania")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompaniaRepository")
 */
class Compania extends BaseClass
{

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="acronimo", type="string", length=15, nullable=false)
     */
    private $acronimo;


    /**
     * @var yacimientos
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Yacimiento", mappedBy="compania")
     *
     */
    private $yacimientos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->yacimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Compania
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Compania
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }


    /**
     * Set acronimo
     *
     * @param string $acronimo
     *
     * @return Compania
     */
    public function setAcronimo($acronimo)
    {
        $this->acronimo = $acronimo;

        return $this;
    }

    /**
     * Get acronimo
     *
     * @return string
     */
    public function getAcronimo()
    {
        return $this->acronimo;
    }


    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Add yacimiento
     *
     * @param \AppBundle\Entity\Yacimiento $yacimiento
     *
     * @return Compania
     */
    public function addYacimiento(\AppBundle\Entity\Yacimiento $yacimiento)
    {
        $this->yacimientos[] = $yacimiento;

        return $this;
    }

    /**
     * Remove yacimiento
     *
     * @param \AppBundle\Entity\Yacimiento $yacimiento
     */
    public function removeYacimiento(\AppBundle\Entity\Yacimiento $yacimiento)
    {
        $this->yacimientos->removeElement($yacimiento);
    }

    /**
     * Get yacimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getYacimientos()
    {
        return $this->yacimientos;
    }


}
