<?php

namespace UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function accessDeniedAction()
    {
        throw new AccessDeniedException('Acceso Prohibido');
    }
}
