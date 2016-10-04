<?php

namespace UsuarioBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use UsuarioBundle\Entity\Usuario;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system.
 */
class UsuarioPasswordModificadoEvent extends Event
{
	const NAME = 'usuario.password.modificado';

	protected $usuario;

	protected $plainPass;

	public function __construct(Usuario $usuario)
	{
		$this->usuario = $usuario;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}
}