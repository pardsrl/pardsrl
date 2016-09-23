<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacion
 *
 * @ORM\Table(name="notificacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificacionRepository")
 */
class Notificacion extends BaseClass
{


	const PERSONAL_TYPE = 'personal';

	const GRUPAL_TYPE   = 'grupal';

	const SISTEMA_TYPE  = 'alerta';

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
     * @ORM\Column(name="notificacion", type="string", length=255)
     */
    private $notificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="prioridad", type="integer")
     */
    private $prioridad;

    /**
     * @var bool
     *
     * @ORM\Column(name="sistema", type="boolean", nullable=true)
     */
    private $sistema;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\NotificacionDistribucion", mappedBy="notificacion")
     */
    private $distribucion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\NotificacionEstado", mappedBy="notificacion",cascade={"persist"})
     */
    private $estados;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estados = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set notificacion
     *
     * @param string $notificacion
     *
     * @return Notificacion
     */
    public function setNotificacion($notificacion)
    {
        $this->notificacion = $notificacion;

        return $this;
    }

    /**
     * Get notificacion
     *
     * @return string
     */
    public function getNotificacion()
    {
        return $this->notificacion;
    }

    /**
     * Set prioridad
     *
     * @param integer $prioridad
     *
     * @return Notificacion
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return integer
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set sistema
     *
     * @param boolean $sistema
     *
     * @return Notificacion
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;

        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }


    /**
     * Set distribucion
     *
     * @param \AppBundle\Entity\NotificacionDistribucion $distribucion
     *
     * @return Notificacion
     */
    public function setDistribucion(\AppBundle\Entity\NotificacionDistribucion $distribucion = null)
    {
        $this->distribucion = $distribucion;

        return $this;
    }

    /**
     * Get distribucion
     *
     * @return \AppBundle\Entity\NotificacionDistribucion
     */
    public function getDistribucion()
    {
        return $this->distribucion;
    }

    /**
     * Add estado
     *
     * @param \AppBundle\Entity\NotificacionEstado $estado
     *
     * @return Notificacion
     */
    public function addEstado(\AppBundle\Entity\NotificacionEstado $estado)
    {
        $this->estados[] = $estado;

        return $this;
    }

    /**
     * Remove estado
     *
     * @param \AppBundle\Entity\NotificacionEstado $estado
     */
    public function removeEstado(\AppBundle\Entity\NotificacionEstado $estado)
    {
        $this->estados->removeElement($estado);
    }

    /**
     * Get estados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstados()
    {
        return $this->estados;
    }


    public function esPersonal(){

    	if (!$this->esSistema() && $this->getDistribucion()->getPersona()){
    		return true;
	    }

	    return false;

    }

    public function esGrupal(){

	    if (!$this->esSistema() && $this->getDistribucion()->getEquipo()){
		    return true;
	    }

	    return false;
    }


    public function esSistema(){
    	return $this->getSistema();
    }

	/**
	 * Devuelve el tipo de notificacion en base a la distribucion de la misma.
	 *
	 * @return string
	 */
    public function getTipo(){

	    if ($this->esSistema()){
		    $type = self::SISTEMA_TYPE;
	    }else{
		    if($this->esPersonal()){
			    $type = self::PERSONAL_TYPE;
		    }else{
			    $type = self::GRUPAL_TYPE;
		    }
	    }

	    return $type;
    }

	/**
	 * Retorna si una notificacion fue leida por una persona dada.
	 *
	 * @param Persona $persona
	 *
	 * @return bool
	 */
    public function getLeidaPor(Persona $persona)
    {
    	foreach ($this->getEstados() as $estado){
    		if ($estado->getPersona() == $persona){
    			return $estado->getLeido();
		    }

	    }

	    return false;
    }

	/**
	 * Setea por default una notificacion como leida, en el caso que no exista un estado para esta notificaion crea una
	 * instancia de NotificacionEstado y lo configura como leido.
	 *
	 * @param Persona $persona
	 * @param bool $leida Se puede marcar como no leida
	 *
	 * @return $this
	 */
    public function setLeidaPor(Persona $persona,$leida = true)
    {

    	$nuevoEstado = true;

	    foreach ( $this->getEstados() as $estado){

		    if ($estado->getPersona() == $persona){

			    $estado->setLeido($leida);

			    $nuevoEstado = false;

		    }
	    }

	    if($nuevoEstado){
		    $estado = new NotificacionEstado();

		    $estado->setNotificacion($this);

		    $estado->setPersona($persona);

		    $estado->setLeido($leida);

		    $this->addEstado($estado);
	    }

	    return $this;
    }

    public function toArray(){
    	return array(
    		'id' => $this->getId(),
		    'notificacion' => $this->getNotificacion()
	    );
    }
}
