<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pozo
 *
 * @ORM\Table(name="pozo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PozoRepository")
 */
class Pozo extends BaseClass
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
     * @var string
     *
     * @ORM\Column(name="profundidad", type="string", length=10)
     */
    private $profundidad;

    /**
     * @var stringd
     *
     * @ORM\Column(name="sistema_extraccion", type="string", length=50)
     */
    private $sistemaExtraccion;

    /**
     * @var string
     *
     * @ORM\Column(name="latitud", type="string", length=50)
     */
    private $latitud;


    /**
     * @var string
     *
     * @ORM\Column(name="longitud", type="string", length=50)
     */
    private $longitud;

    /**
     * @var
     *
     * @ORM\ManyToOne( targetEntity="AppBundle\Entity\Yacimiento", inversedBy="pozos")
     * @ORM\JoinColumn(name="yacimiento_id", referencedColumnName="id", nullable=false)
     */
    private $yacimiento;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Intervencion", mappedBy="pozo")
     */
    private $intervenciones;

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
     * @return Pozo
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
     * @return Pozo
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
     * Set profundidad
     *
     * @param string $profundidad
     *
     * @return Pozo
     */
    public function setProfundidad($profundidad)
    {
        $this->profundidad = $profundidad;

        return $this;
    }

    /**
     * Get profundidad
     *
     * @return string
     */
    public function getProfundidad()
    {
        return $this->profundidad;
    }

    /**
     * Set sistemaExtraccion
     *
     * @param string $sistemaExtraccion
     *
     * @return Pozo
     */
    public function setSistemaExtraccion($sistemaExtraccion)
    {
        $this->sistemaExtraccion = $sistemaExtraccion;

        return $this;
    }

    /**
     * Get sistemaExtraccion
     *
     * @return string
     */
    public function getSistemaExtraccion()
    {
        return $this->sistemaExtraccion;
    }

    /**
     * Set latitud
     *
     * @param string $latitud
     *
     * @return Pozo
     */
    public function setCoordenadas($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return string
     */
    public function getLatitud()
    {
        return $this->latitud;
    }


    /**
     * Set longitud
     *
     * @param string $longitud
     *
     * @return Pozo
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     *
     * Get longitud
     *
     * @return string
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set yacimiento
     *
     * @param \AppBundle\Entity\Yacimiento $yacimiento
     *
     * @return Pozo
     */
    public function setYacimiento(\AppBundle\Entity\Yacimiento $yacimiento = null)
    {
        $this->yacimiento = $yacimiento;

        return $this;
    }

    /**
     * Get yacimiento
     *
     * @return \AppBundle\Entity\Yacimiento
     */
    public function getYacimiento()
    {
        return $this->yacimiento;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->intervenciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set latitud
     *
     * @param string $latitud
     *
     * @return Pozo
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }


    /**
     * Add intervencione
     *
     * @param \AppBundle\Entity\Intervencion $intervencione
     *
     * @return Pozo
     */
    public function addIntervencione(\AppBundle\Entity\Intervencion $intervencione)
    {
        $this->intervenciones[] = $intervencione;

        return $this;
    }

    /**
     * Remove intervencione
     *
     * @param \AppBundle\Entity\Intervencion $intervencione
     */
    public function removeIntervencione(\AppBundle\Entity\Intervencion $intervencione)
    {
        $this->intervenciones->removeElement($intervencione);
    }

    /**
     * Get intervenciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIntervenciones()
    {
        return $this->intervenciones;
    }

    /**
     *
     *
     * @return Intervencion|null
     */
    public function getUltimaIntervencion(){

        $intervencion = null;

        if( $this->getIntervenciones()->count()){
            $intervencion = $this->getIntervenciones()->last();
        }

        return $intervencion;
    }

    /**
     * Busca la accion de la ultima intervencion realizada en el pozo
     *
     *
     * @return int 0 (abierto) 1 (cerrado)
     */
    public function getEstadoUltimaIntervencion(){

        $estado = 1; //Por defecto el pozo se encuentra cerrado

        $ultimaIntervencion = $this->getUltimaIntervencion();

        if($ultimaIntervencion){
           $estado = $ultimaIntervencion->getAccion();
        }

        return $estado;
    }


    public function estaAbierto(){
        return !$this->getEstadoUltimaIntervencion();
    }


    public function __toString()
    {
        return $this->getNombre();
    }
}
