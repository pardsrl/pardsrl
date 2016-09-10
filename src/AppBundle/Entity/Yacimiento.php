<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Yacimiento
 *
 * @ORM\Table(name="yacimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\YacimientoRepository")
 */
class Yacimiento extends BaseClass
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="acronimo", type="string", length=25)
     */
    private $acronimo;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pozo", mappedBy="yacimiento")
     */
    private $pozos;


    /**
     * @var
     *
     * @ORM\ManyToOne( targetEntity="AppBundle\Entity\Localidad")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id", nullable=false)
     */
    private $localidad;


    /**
     * @var
     *
     * @ORM\ManyToOne( targetEntity="AppBundle\Entity\Compania", inversedBy="yacimientos")
     * @ORM\JoinColumn(name="compania_id", referencedColumnName="id", nullable=false)
     */
    private $compania;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pozos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Yacimiento
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
     * Set acronimo
     *
     * @param string $acronimo
     *
     * @return Yacimiento
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

    /**
     * Add pozo
     *
     * @param \AppBundle\Entity\Pozo $pozo
     *
     * @return Yacimiento
     */
    public function addPozo(\AppBundle\Entity\Pozo $pozo)
    {
        $this->pozos[] = $pozo;

        return $this;
    }

    /**
     * Remove pozo
     *
     * @param \AppBundle\Entity\Pozo $pozo
     */
    public function removePozo(\AppBundle\Entity\Pozo $pozo)
    {
        $this->pozos->removeElement($pozo);
    }

    /**
     * Get pozos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPozos()
    {
        return $this->pozos;
    }

    /**
     * Set localidad
     *
     * @param \AppBundle\Entity\Localidad $localidad
     *
     * @return Yacimiento
     */
    public function setLocalidad(\AppBundle\Entity\Localidad $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \AppBundle\Entity\Localidad
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set compania
     *
     * @param \AppBundle\Entity\Compania $compania
     *
     * @return Yacimiento
     */
    public function setCompania(\AppBundle\Entity\Compania $compania = null)
    {
        $this->compania = $compania;

        return $this;
    }

    /**
     * Get compania
     *
     * @return \AppBundle\Entity\Compania
     */
    public function getCompania()
    {
        return $this->compania;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
