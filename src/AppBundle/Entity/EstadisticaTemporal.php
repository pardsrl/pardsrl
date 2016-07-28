<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * EstadisticasTemporales
 *
 * @ORM\Table(name="estadistica_temporal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EstadisticaTemporalRepository")
 */
class EstadisticaTemporal extends BaseClass
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
     * @var array
     *
     * @ORM\Column(name="datos", type="json_array", nullable=true)
     */
    private $datos;

    /**
     * @var $equipo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipo", inversedBy="estadisticas")
     * @ORM\JoinColumn(name="equipo_id", referencedColumnName="id", nullable=false)
     */
    private $equipo;

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
     * Set datos
     *
     * @param array $datos
     *
     * @return EstadisticasTemporales
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     *
     * @return EstadisticasTemporales
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
}
