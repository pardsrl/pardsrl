<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use UsuarioBundle\Services\SecurityManager;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $usuario = $this->container->get('security.token_storage')->getToken()->getUser();

        $securityManager =  $this->container->get('security.manager');

        $em = $this->container->get('doctrine')->getManager();

        $misEquipos = $usuario->getPersona()->getEquiposActivos();

        $roles = $usuario->getRoles();

        $rol  = $roles[0];

        $menu = $factory->createItem(
            'root',
            array(
                'childrenAttributes' => array(
                    'class' => 'sidebar-menu',
                ),
            )
        );


        if ($securityManager->isGranted($rol, 'dashboard') || $usuario->hasRole('ROLE_SUPER_ADMIN')) {
            $menu->addChild('Dashboard', array('route' => 'dashboard'))->setExtra('icon', 'fa fa-area-chart');
        }

        //TODO siempre se están generando estas rutas si el usuario tiene asignado equipos

        if($misEquipos->count()){
            $menu->addChild('MIS EQUIPOS')->setAttribute('class', 'header');

            foreach ($misEquipos as $equipo) {

                $menu->addChild(
                    $equipo->getNombre(),
                    array(
                        'childrenAttributes' => array(
                            'class' => 'treeview-menu',
                        ),
                    )
                )
                    ->setUri('#')
                    ->setExtra('icon', 'fa fa-circle-o text-aqua')
                    ->setAttribute('class', 'treeview');

                $menu[$equipo->getNombre()]->addChild(
                    'Estadísticas',
                    array('route' => 'equipo_estadisticas', 'routeParameters' => array('id' => $equipo->getId()))
                )->setExtra('icon', 'fa fa-bar-chart');

                $menu[$equipo->getNombre()]->addChild(
                    'Instrumentos',
                    array('route' => 'equipo_instrumentos', 'routeParameters' => array('id' => $equipo->getId()))
                )->setExtra('icon', 'fa  fa-cogs');

            }
        }

        //Se genera  el resto del menu desde la tabla usr_menu

        $itemsQuery = $em->getRepository('UsuarioBundle:Menu')->getPadresActivos()->getQuery();

        $items = $itemsQuery->getResult();


        foreach ($items as $item) {

            if ($item->tieneHijos()) {

                $generarMenu = false;

                foreach ($item->getHijos() as $hijo) {

                    $ruta = $hijo->getAccion()->getRuta();

                    if ($securityManager->isGranted($rol, $ruta) || $usuario->hasRole('ROLE_SUPER_ADMIN')) {
                        $generarMenu = true;
                    }
                }

                if ($generarMenu) {

                    $menu->addChild(
                        $item->getNombre(),
                        array(
                            'childrenAttributes' => array(
                                'class' => 'treeview-menu',
                            ),
                        )
                    )
                        ->setUri('#')
                        ->setExtra('icon', 'fa ' . $item->getClaseIcono())
                        ->setAttribute('class', 'treeview');

                    foreach ($item->getHijos() as $itemsHijo) {

                        $menu[$item->getNombre()]->addChild(
                            $itemsHijo->getNombre(),
                            array('route' => $itemsHijo->getAccion()->getRuta())
                        )->setExtra('icon', 'fa ' . $itemsHijo->getClaseIcono());

                    }
                }

            } else {

                if ($item->getAccion()) {
                    $ruta = $item->getAccion()->getRuta();


                    if ($securityManager->isGranted($rol, $ruta) || $usuario->hasRole('ROLE_SUPER_ADMIN')) {
                        $menu->addChild($item->getNombre(), array('route' => $ruta))->setExtra('icon',
                            'fa ' . $item->getClaseIcono());
                    }
                    //es un header (no tiene accion y tampoco tiene ruta)
                } else {
                    $menu->addChild(strtoupper($item->getNombre()))->setAttribute('class', 'header');
                }

            }
        }

        return $menu;
    }
}