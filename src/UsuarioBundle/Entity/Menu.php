<?php

namespace UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="usr_menu")
 * @ORM\Entity(repositoryClass="UsuarioBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="clase_icono", type="string", length=255, nullable=true)
     */
    private $claseIcono;


    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="padre")
     * @ORM\OrderBy({"orden" = "ASC"})
     */
    private $hijos;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Menu", inversedBy="hijos")
     * @ORM\JoinColumn(name="padre_id" , referencedColumnName="id")
     */
    private $padre;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Accion")
     * @ORM\JoinColumn(name="accion_id" , referencedColumnName="id")
     */
    private $accion;

    /**
     * @var
     *
     * @ORM\Column(name="orden" , type="integer", nullable=false)
     */
    private $orden;


    /**
     * @var
     *
     * @ORM\Column(name="activo" , type="boolean", nullable=false)
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
     * @return Menu
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
     * @return Menu
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
     * Set claseIcono
     *
     * @param string $claseIcono
     *
     * @return Menu
     */
    public function setClaseIcono($claseIcono)
    {
        $this->claseIcono = $claseIcono;

        return $this;
    }

    /**
     * Get claseIcono
     *
     * @return string
     */
    public function getClaseIcono()
    {
        return $this->claseIcono;
    }

    /**
     * Set padre
     *
     * @param \UsuarioBundle\Entity\Menu $padre
     *
     * @return Menu
     */
    public function setPadre(\UsuarioBundle\Entity\Menu $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \UsuarioBundle\Entity\Menu
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set accion
     *
     * @param \UsuarioBundle\Entity\Accion $accion
     *
     * @return Menu
     */
    public function setAccion(\UsuarioBundle\Entity\Accion $accion = null)
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Menu
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Menu
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
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
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add hijo
     *
     * @param \UsuarioBundle\Entity\Menu $hijo
     *
     * @return Menu
     */
    public function addHijo(\UsuarioBundle\Entity\Menu $hijo)
    {
        $this->hijos[] = $hijo;

        return $this;
    }

    /**
     * Remove hijo
     *
     * @param \UsuarioBundle\Entity\Menu $hijo
     */
    public function removeHijo(\UsuarioBundle\Entity\Menu $hijo)
    {
        $this->hijos->removeElement($hijo);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHijos()
    {
        return $this->hijos;
    }

    /**
     * @return bool
     */
    public function tieneHijos()
    {
        return $this->hijos->count() ? true : false;
    }

    public function getHijosActivos(){

        $filtro = function($item) {

            if($item->getActivo()){
                return true;
            }else{
                return false;
            }
        };

        return $this->getHijos()->filter($filtro);
    }

    /**
     * @return bool
     */
    public function tieneHijosActivos()
    {
        return $this->getHijosActivos()->count() ? true : false;
    }


    public function esHeader(){

        if($this->getAccion() === null && $this->tieneHijos() ){

            $header = true;

            foreach ($this->getHijosActivos() as $hijo){
                if($hijo->getAccion()){
                    $header = false;
                }
            }

            return $header;

        }

        return false;
    }

    public function esSubMenu(){

        return $this->esHeader() ? false : true;
    }

    public function esLink(){
        if($this->getAccion() && !$this->tieneHijos()){
            return true;
        }

        return false;

    }
}
