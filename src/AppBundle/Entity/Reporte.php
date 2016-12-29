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
}

