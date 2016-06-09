<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pais
 *
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaisRepository")
 */
class Pais
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="codigo_pais", type="integer")
     */
    private $codigoPais;


    /**
     * @var provincias
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Provincia",mappedBy="pais")
     */
    private $provincias;
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Pais
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
     * Set codigoPais
     *
     * @param integer $codigoPais
     *
     * @return Pais
     */
    public function setCodigoPais($codigoPais)
    {
        $this->codigoPais = $codigoPais;

        return $this;
    }

    /**
     * Get codigoPais
     *
     * @return int
     */
    public function getCodigoPais()
    {
        return $this->codigoPais;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->provincias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     *
     * @return Pais
     */
    public function addProvincia(\AppBundle\Entity\Provincia $provincia)
    {
        $this->provincias[] = $provincia;

        return $this;
    }

    /**
     * Remove provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     */
    public function removeProvincia(\AppBundle\Entity\Provincia $provincia)
    {
        $this->provincias->removeElement($provincia);
    }

    /**
     * Get provincias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvincias()
    {
        return $this->provincias;
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }
}
