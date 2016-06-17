<?php

namespace UsuarioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Funcionalidad
 *
 * @ORM\Table(name="usr_funcionalidad")
 * @ORM\Entity(repositoryClass="UsuarioBundle\Repository\FuncionalidadRepository")
 */
class Funcionalidad
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
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="UsuarioBundle\Entity\FuncionalidadAccion", mappedBy="funcionalidad", cascade={"persist", "remove"})
     */
    private $funcionalidadesAccion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;


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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Funcionalidad
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Funcionalidad
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
     * @return Funcionalidad
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
     * Constructor
     */
    public function __construct()
    {
        $this->funcionalidadesAccion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add funcionalidadesAccion
     *
     * @param \UsuarioBundle\Entity\FuncionalidadAccion $funcionalidadesAccion
     *
     * @return Funcionalidad
     */
    public function addFuncionalidadesAccion(\UsuarioBundle\Entity\FuncionalidadAccion $funcionalidadesAccion)
    {
        $this->funcionalidadesAccion[] = $funcionalidadesAccion;

        return $this;
    }

    /**
     * Remove funcionalidadesAccion
     *
     * @param \UsuarioBundle\Entity\FuncionalidadAccion $funcionalidadesAccion
     */
    public function removeFuncionalidadesAccion(\UsuarioBundle\Entity\FuncionalidadAccion $funcionalidadesAccion)
    {
        $this->funcionalidadesAccion->removeElement($funcionalidadesAccion);
    }

    /**
     * Get funcionalidadesAccion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFuncionalidadesAccion()
    {
        return $this->funcionalidadesAccion;
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     *
     * Retorna las acciones activas para las funcionalidad dada
     * @return ArrayCollection
     */
    public function getAcciones()
    {
        $acciones = new ArrayCollection();

        foreach ($this->getFuncionalidadesAccion() as $funcionalidadAccion) {
            if($funcionalidadAccion->getActivo()){
                $acciones->add($funcionalidadAccion->getAccion());
            }
        }

        return $acciones;
    }
}
