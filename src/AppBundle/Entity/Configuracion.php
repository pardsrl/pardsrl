<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuracion
 *
 * @ORM\Table(name="configuracion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfiguracionRepository")
 */
class Configuracion
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
     * @ORM\Column(name="configuracion", type="json_array")
     */
    private $configuracion;

	/**
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Persona", inversedBy="configuracion" , cascade={"persist","remove"})
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
	 */
	private $persona;

	public function __construct() {

		$defConfig = $this->getDefault();

		$this->setConfiguracion($defConfig);

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
     * Set configuracion
     *
     * @param array $configuracion
     *
     * @return Configuracion
     */
    public function setConfiguracion($configuracion)
    {
        $this->configuracion = $configuracion;

        return $this;
    }

    /**
     * Get configuracion
     *
     * @return array
     */
    public function getConfiguracion()
    {
        return $this->configuracion;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return Configuracion
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }


    public function getConfig($key){

    	$aConfig = $this->getConfiguracion();

	    if(is_null($aConfig)) return null;

    	return array_key_exists($key,$aConfig) ? $aConfig[$key] : null;

    }

	/**
	 * @return array
	 */
    public function getDefault(){

	    return array(
		    'historicoPozo'       => true,
		    'historicoManiobras'  => true,
		    'tiempoRealPozo'      => true,
		    'tiempoRealManiobras' => true
	    );
    }


}
