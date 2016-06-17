<?php

namespace UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DefaultController extends Controller
{
    public function accessDeniedAction()
    {
        throw new AccessDeniedHttpException('Acceso Prohibido');
    }
}
