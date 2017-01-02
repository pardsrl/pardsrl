<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reporte
 *
 * @ORM\Table(name="reporte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReporteRepository")
 */
class Reporte extends BaseClass
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
     * @ORM\Column(name="recurso", type="string", length=255)
     */
    private $recurso;

    /**
     * @var int
     *
     * @ORM\Column(name="recurso_id", type="integer")
     */
    private $recursoId;

    /**
     * @var string
     *
     * @ORM\Column(name="reporte", type="text")
     */
    private $reporte;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nombre_archivo", type="string", length=255)
	 */
	private $nombreArchivo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="observaciones", type="string", nullable=true, length=500)
	 */
	private $observaciones;


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
     * Set recurso
     *
     * @param string $recurso
     *
     * @return Reporte
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
     * Set recursoId
     *
     * @param integer $recursoId
     *
     * @return Reporte
     */
    public function setRecursoId($recursoId)
    {
        $this->recursoId = $recursoId;

        return $this;
    }

    /**
     * Get recursoId
     *
     * @return int
     */
    public function getRecursoId()
    {
        return $this->recursoId;
    }

    /**
     * Set reporte
     *
     * @param string $reporte
     *
     * @return Reporte
     */
    public function setReporte($reporte)
    {
        $this->reporte = $reporte;

        return $this;
    }

    /**
     * Get reporte
     *
     * @return string
     */
    public function getReporte()
    {
        return $this->reporte;
    }

	/**
	 * Get nombreArchivo
	 *
	 * @return string
	 */
	public function getNombreArchivo() {
		return $this->nombreArchivo;
	}

	/**
	 * Set nombreArchivo
	 *
	 * @param string $nombreArchivo
	 *
	 * @return Reporte
	 */
	public function setNombreArchivo( $nombreArchivo ) {
		$this->nombreArchivo = $nombreArchivo;
	}

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Reporte
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
}

