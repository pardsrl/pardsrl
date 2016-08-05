<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadisticaFinal
 *
 * @ORM\Table(name="estadistica_final")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EstadisticaFinalRepository")
 */
class EstadisticaFinal
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
     * @ORM\Column(name="tiempo_total", type="string", length=255)
     */
    private $tiempoTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo_maniobras", type="string", length=255)
     */
    private $tiempoManiobras;

    /**
     * @var float
     *
     * @ORM\Column(name="prom_vb", type="float")
     */
    private $promVb;

    /**
     * @var float
     *
     * @ORM\Column(name="prom_tbg", type="float")
     */
    private $promTbg;

    /**
     * @var float
     *
     * @ORM\Column(name="ftu", type="float")
     */
    private $ftu;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_alertas", type="integer")
     */
    private $cantAlertas;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo_online", type="string", length=255)
     */
    private $tiempoOnline;

    /**
     * @var bool
     *
     * @ORM\Column(name="observada", type="boolean")
     */
    private $observada;

    /**
     * @var text
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Intervencion")
     * @ORM\JoinColumn(name="intervencion_id", referencedColumnName="id")
     */
    private $intervencion;

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
     * Set tiempoTotal
     *
     * @param string $tiempoTotal
     *
     * @return EstadisticaFinal
     */
    public function setTiempoTotal($tiempoTotal)
    {
        $this->tiempoTotal = $tiempoTotal;

        return $this;
    }

    /**
     * Get tiempoTotal
     *
     * @return string
     */
    public function getTiempoTotal()
    {
        return $this->tiempoTotal;
    }

    /**
     * Set tiempoManiobras
     *
     * @param string $tiempoManiobras
     *
     * @return EstadisticaFinal
     */
    public function setTiempoManiobras($tiempoManiobras)
    {
        $this->tiempoManiobras = $tiempoManiobras;

        return $this;
    }

    /**
     * Get tiempoManiobras
     *
     * @return string
     */
    public function getTiempoManiobras()
    {
        return $this->tiempoManiobras;
    }

    /**
     * Set promVb
     *
     * @param float $promVb
     *
     * @return EstadisticaFinal
     */
    public function setPromVb($promVb)
    {
        $this->promVb = $promVb;

        return $this;
    }

    /**
     * Get promVb
     *
     * @return float
     */
    public function getPromVb()
    {
        return $this->promVb;
    }

    /**
     * Set promTbg
     *
     * @param float $promTbg
     *
     * @return EstadisticaFinal
     */
    public function setPromTbg($promTbg)
    {
        $this->promTbg = $promTbg;

        return $this;
    }

    /**
     * Get promTbg
     *
     * @return float
     */
    public function getPromTbg()
    {
        return $this->promTbg;
    }

    /**
     * Set ftu
     *
     * @param float $ftu
     *
     * @return EstadisticaFinal
     */
    public function setFtu($ftu)
    {
        $this->ftu = $ftu;

        return $this;
    }

    /**
     * Get ftu
     *
     * @return float
     */
    public function getFtu()
    {
        return $this->ftu;
    }

    /**
     * Set cantAlertas
     *
     * @param integer $cantAlertas
     *
     * @return EstadisticaFinal
     */
    public function setCantAlertas($cantAlertas)
    {
        $this->cantAlertas = $cantAlertas;

        return $this;
    }

    /**
     * Get cantAlertas
     *
     * @return int
     */
    public function getCantAlertas()
    {
        return $this->cantAlertas;
    }

    /**
     * Set tiempoOnline
     *
     * @param string $tiempoOnline
     *
     * @return EstadisticaFinal
     */
    public function setTiempoOnline($tiempoOnline)
    {
        $this->tiempoOnline = $tiempoOnline;

        return $this;
    }

    /**
     * Get tiempoOnline
     *
     * @return string
     */
    public function getTiempoOnline()
    {
        return $this->tiempoOnline;
    }

    /**
     * Set observada
     *
     * @param boolean $observada
     *
     * @return EstadisticaFinal
     */
    public function setObservada($observada)
    {
        $this->observada = $observada;

        return $this;
    }

    /**
     * Get observada
     *
     * @return bool
     */
    public function getObservada()
    {
        return $this->observada;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return EstadisticaFinal
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
     * Set intervencion
     *
     * @param \AppBundle\Entity\Intervencion $intervencion
     *
     * @return EstadisticaFinal
     */
    public function setIntervencion(\AppBundle\Entity\Intervencion $intervencion = null)
    {
        $this->intervencion = $intervencion;

        return $this;
    }

    /**
     * Get intervencion
     *
     * @return \AppBundle\Entity\Intervencion
     */
    public function getIntervencion()
    {
        return $this->intervencion;
    }
}
