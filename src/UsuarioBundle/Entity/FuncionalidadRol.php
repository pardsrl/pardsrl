<?php

namespace UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FuncionalidadRol
 *
 * @ORM\Table(name="usr_funcionalidad_rol")
 * @ORM\Entity(repositoryClass="UsuarioBundle\Repository\FuncionalidadRolRepository")
 */
class FuncionalidadRol
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
     * @var
     *
     * @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Rol", inversedBy="funcionalidadesRol")
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id",nullable=false)
     */
    private $rol;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Funcionalidad")
     * @ORM\JoinColumn(name="funcionalidad_id", referencedColumnName="id",nullable=false)
     */
    private $funcionalidad;

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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FuncionalidadRol
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
     * Set rol
     *
     * @param \UsuarioBundle\Entity\Rol $rol
     *
     * @return FuncionalidadRol
     */
    public function setRol(\UsuarioBundle\Entity\Rol $rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \UsuarioBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set funcionalidad
     *
     * @param \UsuarioBundle\Entity\Funcionalidad $funcionalidad
     *
     * @return FuncionalidadRol
     */
    public function setFuncionalidad(\UsuarioBundle\Entity\Funcionalidad $funcionalidad)
    {
        $this->funcionalidad = $funcionalidad;

        return $this;
    }

    /**
     * Get funcionalidad
     *
     * @return \UsuarioBundle\Entity\Funcionalidad
     */
    public function getFuncionalidad()
    {
        return $this->funcionalidad;
    }
}
