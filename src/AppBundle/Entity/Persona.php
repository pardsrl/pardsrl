<?php
// src/AppBundle/Entity/Persona.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="persona")
 */
class Persona
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var String $nombre
     *
     * @ORM\Column(type="string" , length=150)
     */
    protected $nombre;

    /**
     *
     * @var String $apellido
     *
     * @ORM\Column(type="string" , length=50)
     */
    protected $apellido;


    /**
     *
     * @var String $telefonoPrincipal
     *
     * @ORM\Column(type="string" , length=50)
     */
    protected $telefonoPrincipal;

    /**
     *
     * @var String $telefonoSecundario
     *
     * @ORM\Column(type="string" , length=50, nullable=true)
     */
    protected $telefonoSecundario;

    /**
     *
     * @var String $cargo
     *
     * @ORM\Column(type="string" , length=50)
     */
    protected $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Compania")
     * @ORM\JoinColumn(name="compania_id", referencedColumnName="id")
     */
    protected $compania;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Equipo", mappedBy="personas")
     * @ORM\JoinTable(name="persona_equipo")
     */
    private $equipos;
    /**
     * @ORM\OneToOne(targetEntity="UsuarioBundle\Entity\Usuario" ,  inversedBy="persona" ,cascade={"persist"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;

    /**
     * @var \DateTime $fechaCreacion
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $fechaCreacion;
    /**
     * @var \DateTime $fechaActualizacion
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $fechaActualizacion;

    /**
     * @var string $creadoPor
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\Column
     */
    protected $creadoPor;

    /**
     * @var string $actualizadoPor
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\Column
     */
    protected $actualizadoPor;


    /**
     * Set nombreCompleto
     *
     * @param string $nombre
     *
     * @return Persona
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombreCompleto
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Persona
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set telefonoPrincipal
     *
     * @param string $telefonoPrincipal
     *
     * @return Persona
     */
    public function setTelefonoPrincipal($telefonoPrincipal)
    {
        $this->telefonoPrincipal = $telefonoPrincipal;

        return $this;
    }

    /**
     * Get telefonoPrincipal
     *
     * @return string
     */
    public function getTelefonoPrincipal()
    {
        return $this->telefonoPrincipal;
    }

    /**
     * Set telefonoSecundario
     *
     * @param string $telefonoSecundario
     *
     * @return Persona
     */
    public function setTelefonoSecundario($telefonoSecundario)
    {
        $this->telefonoSecundario = $telefonoSecundario;

        return $this;
    }

    /**
     * Get telefonoSecundario
     *
     * @return string
     */
    public function getTelefonoSecundario()
    {
        return $this->telefonoSecundario;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Persona
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return Persona
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * Set creadoPor
     *
     * @param string $creadoPor
     *
     * @return Persona
     */
    public function setCreadoPor($creadoPor)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Get creadoPor
     *
     * @return string
     */
    public function getCreadoPor()
    {
        return $this->creadoPor;
    }

    /**
     * Set actualizadoPor
     *
     * @param string $actualizadoPor
     *
     * @return Persona
     */
    public function setActualizadoPor($actualizadoPor)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Get actualizadoPor
     *
     * @return string
     */
    public function getActualizadoPor()
    {
        return $this->actualizadoPor;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Persona
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set compania
     *
     * @param \AppBundle\Entity\Compania $compania
     *
     * @return Persona
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
     * Set usuario
     *
     * @param \UsuarioBundle\Entity\Usuario $usuario
     *
     * @return Persona
     */
    public function setUsuario(\UsuarioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \UsuarioBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     *
     * @return Persona
     */
    public function addEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipos[] = $equipo;

        return $this;
    }

    /**
     * Remove equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     */
    public function removeEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipos->removeElement($equipo);
    }

    /**
     * Get equipos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipos()
    {
        return $this->equipos;
    }

    public function getNombreCompleto(){
        return sprintf('%s %s',$this->getNombre(),$this->getApellido());
    }


    public function __toString()
    {
        return $this->getNombreCompleto();
    }

    public function getEquiposActivos(){

        $filtro = function($equipo) {
            return $equipo->getActivo() === TRUE;
        };

        return $this->getEquipos()->filter($filtro);
    }
}
