<?php

namespace UsuarioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table(name="usr_rol")
 * @ORM\Entity(repositoryClass="UsuarioBundle\Repository\RolRepository")
 */
class Rol
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100, unique=true)
     */
    private $slug;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="UsuarioBundle\Entity\FuncionalidadRol",mappedBy="rol", cascade={"persist","remove"})
     */
    private $funcionalidadesRol;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * @return Rol
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Rol
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Rol
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->funcionalidadesRol = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add funcionalidadesRol
     *
     * @param \UsuarioBundle\Entity\FuncionalidadRol $funcionalidadesRol
     *
     * @return Rol
     */
    public function addFuncionalidadesRol(\UsuarioBundle\Entity\FuncionalidadRol $funcionalidadesRol)
    {
        $this->funcionalidadesRol[] = $funcionalidadesRol;

        return $this;
    }

    /**
     * Remove funcionalidadesRol
     *
     * @param \UsuarioBundle\Entity\FuncionalidadRol $funcionalidadesRol
     */
    public function removeFuncionalidadesRol(\UsuarioBundle\Entity\FuncionalidadRol $funcionalidadesRol)
    {
        $this->funcionalidadesRol->removeElement($funcionalidadesRol);
    }

    /**
     * Get funcionalidadesRol
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFuncionalidadesRol()
    {
        return $this->funcionalidadesRol;
    }


    /**
     * Devuelve una coleccion de funcionalidades activas de un determinado Rol.
     *
     * @return ArrayCollection
     */
    public function getFuncionalidades()
    {
        $funcionalidades = new ArrayCollection();

        foreach ($this->getFuncionalidadesRol() as $funcionalidadRol) {
            if($funcionalidadRol->getActivo()){
                $funcionalidades->add($funcionalidadRol->getFuncionalidad());
            }
        }

        return $funcionalidades;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
