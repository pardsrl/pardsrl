<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoRecurso
 *
 * @ORM\Table(name="tipo_recurso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoRecursoRepository")
 */
class TipoRecurso
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
	 * @var recurso
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recurso",mappedBy="tipoRecurso")
	 */
	private $recursos;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->recursos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return TipoRecurso
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
     * @return TipoRecurso
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
     * Set slug
     *
     * @param string $slug
     *
     * @return TipoRecurso
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Add recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     *
     * @return TipoRecurso
     */
    public function addRecurso(\AppBundle\Entity\Recurso $recurso)
    {
        $this->recursos[] = $recurso;

        return $this;
    }

    /**
     * Remove recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     */
    public function removeRecurso(\AppBundle\Entity\Recurso $recurso)
    {
        $this->recursos->removeElement($recurso);
    }

    /**
     * Get recursos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecursos()
    {
        return $this->recursos;
    }
}
