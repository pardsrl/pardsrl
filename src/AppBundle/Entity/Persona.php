<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="persona")
 */
class Persona extends BaseClass
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
     * @var String $sexo
     *
     * @ORM\Column(type="string" , length=50)
     */
    protected $sexo;

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
     * @Assert\NotNull(message="Debe asociar un cargo de forma obligatoria.")
     *
     * @var String $cargo
     *
     * @ORM\Column(type="string" , length=50)
     */
    protected $cargo;

    /**
     * @Assert\NotNull(message="Debe asociar una compañia a la nueva persona.}")
     *
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
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
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Persona
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
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
     * @param \AppBundle\Entity $compania
     *
     * @return Persona
     */
    public function setCompania(Compania $compania = null)
    {
        $this->compania = $compania;

        return $this;
    }

    /**
     * Get compania
     *
     * @return \AppBundle\Entity
     */
    public function getCompania()
    {
        return $this->compania;
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

    /**
     * Retorna el nombre completo del objeto Persona
     *
     * @return string
     */
    public function getNombreCompleto(){
        return sprintf('%s %s',$this->getNombre(),$this->getApellido());
    }

    /**
     * Retorna todos los equipos activos que se encuentra activos y configurados para el objeto Persona
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquiposActivos(){

        $filtro = function($equipo) {
            return $equipo->getActivo() === TRUE;
        };

        return $this->getEquipos()->filter($filtro);
    }

    public function __toString()
    {
        return $this->getNombreCompleto();
    }
}
