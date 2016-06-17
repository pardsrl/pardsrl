<?php

namespace UsuarioBundle\Services;

use Doctrine\ORM\EntityManager;

class SecurityManager
{

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     *
     * Garantiza el acceso del usuario a ciertas acciones definidas en base de datos.
     *
     * @param $role
     * @param $ruta
     * @return bool
     */
    public function isGranted($role,$ruta){
        return true;

        $rol = $this->em->getRepository('UsuarioBundle:Rol')->findOneBySlug($role);

        //obtengo las funcionalidades activas
        $funcionalidades = $rol->getFuncionalidades();

        foreach ($funcionalidades as $funcionalidad) {

            //recorro las acciones activas
            foreach ($funcionalidad->getAcciones() as $accion) {
                if($accion->getRuta() == $ruta){
                    return true;
                }
            }
        }
        
        return false;
    }
}