<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reporte
 *
 * @ORM\Table(name="recurso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecursoRepository")
 */
class Recurso extends BaseClass {
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
	 * @ORM\Column(name="recurso", type="string", length=255)
	 */
	private $recurso;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="objeto_id", type="integer")
	 */
	private $objetoId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="url", type="string", length=500)
	 */
	private $url;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nombre_archivo", type="string", length=255)
	 */
	private $nombreArchivo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="extension", type="string", length=10)
	 */
	private $extension;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="observaciones", type="string", nullable=true, length=500)
	 */
	private $observaciones;


	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoRecurso", inversedBy="recursos")
	 * @ORM\JoinColumn(name="tipo_recurso", referencedColumnName="id", nullable=false)
	 */
	private $tipoRecurso;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set recurso
     *
     * @param string $recurso
     *
     * @return Recurso
     */
    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso
     *
     * @return string
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set objetoId
     *
     * @param integer $objetoId
     *
     * @return Recurso
     */
    public function setObjetoId($objetoId)
    {
        $this->objetoId = $objetoId;

        return $this;
    }

    /**
     * Get objetoId
     *
     * @return integer
     */
    public function getObjetoId()
    {
        return $this->objetoId;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Recurso
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set nombreArchivo
     *
     * @param string $nombreArchivo
     *
     * @return Recurso
     */
    public function setNombreArchivo($nombreArchivo)
    {
        $this->nombreArchivo = $nombreArchivo;

        return $this;
    }

    /**
     * Get nombreArchivo
     *
     * @return string
     */
    public function getNombreArchivo()
    {
        return $this->nombreArchivo;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Recurso
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Recurso
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }


    /**
     * Set tipoRecurso
     *
     * @param \AppBundle\Entity\TipoRecurso $tipoRecurso
     *
     * @return Recurso
     */
    public function setTipoRecurso(\AppBundle\Entity\TipoRecurso $tipoRecurso)
    {
        $this->tipoRecurso = $tipoRecurso;

        return $this;
    }

    /**
     * Get tipoRecurso
     *
     * @return \AppBundle\Entity\TipoRecurso
     */
    public function getTipoRecurso()
    {
        return $this->tipoRecurso;
    }

}
