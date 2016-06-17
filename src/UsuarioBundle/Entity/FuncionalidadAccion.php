<?php

namespace UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * FuncionalidadAccion
 *
 * @ORM\Table(name="usr_funcionalidad_accion")
 * @ORM\Entity(repositoryClass="UsuarioBundle\Repository\FuncionalidadAccionRepository")
 * @UniqueEntity(
 *     fields={"accion", "funcionalidad"},
 *     errorPath="accion",
 *     message="La accion ya se ha registrado para esta funcionalidad."
 * )
 */
class FuncionalidadAccion
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
     * @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Accion")
     * @ORM\JoinColumn(name="accion_id", referencedColumnName="id",nullable=false)
     */
    private $accion;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Funcionalidad", inversedBy="funcionalidadesAccion")
     * @ORM\JoinColumn(name="funcionalidad_id", referencedColumnName="id",nullable=false)
     */
    private $funcionalidad;
    
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
     * @return FuncionalidadAccion
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
     * Set accion
     *
     * @param \UsuarioBundle\Entity\Accion $accion
     *
     * @return FuncionalidadAccion
     */
    public function setAccion(\UsuarioBundle\Entity\Accion $accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return \UsuarioBundle\Entity\Accion
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set funcionalidad
     *
     * @param \UsuarioBundle\Entity\Funcionalidad $funcionalidad
     *
     * @return FuncionalidadAccion
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
