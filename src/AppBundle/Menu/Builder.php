<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $usuario = $this->container->get('security.token_storage')->getToken()->getUser();

        $misEquipos = $usuario->getPersona()->getEquiposActivos();

        $menu = $factory->createItem(
            'root',
            array(
                'childrenAttributes' => array(
                    'class' => 'sidebar-menu',
                ),
            )
        );



        $menu->addChild('Dashboard', array('route' => 'dashboard'))->setExtra( 'icon', 'fa fa-area-chart' );

        $menu->addChild('MIS EQUIPOS')->setAttribute( 'class', 'header' );

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
                array('route' => 'equipo_estadisticas','routeParameters' => array('id' => $equipo->getId()))
            )->setExtra( 'icon', 'fa fa-bar-chart');

            $menu[$equipo->getNombre()]->addChild(
                'Instrumentos',
                array('route' => 'equipo_instrumentos','routeParameters' => array('id' => $equipo->getId()))
            )->setExtra( 'icon', 'fa  fa-cogs');

        }

        $menu->addChild('ADMINISTRACIÓN')->setAttribute( 'class', 'header' );

        $menu->addChild(
            'Compañías',
            array(
                'childrenAttributes' => array(
                    'class' => 'treeview-menu',
                ),
            )
        )
            ->setUri('#')
            ->setExtra('icon', 'fa  fa-building-o')
            ->setAttribute('class', 'treeview');

        $menu['Compañías']->addChild(
            'Listado',
            array('route' => 'compania_index')
        )->setExtra( 'icon', 'fa fa-circle-o');

        $menu['Compañías']->addChild(
            'Nueva Compañía',
            array('route' => 'compania_new')
        )->setExtra( 'icon', 'fa fa-circle-o');

        $menu->addChild(
            'Equipos',
            array(
                'childrenAttributes' => array(
                    'class' => 'treeview-menu',
                ),
            )
        )
            ->setUri( '#' )
            ->setExtra( 'icon', 'fa fa-cubes' )
            ->setAttribute( 'class', 'treeview' );

        $menu['Equipos']->addChild(
            'Listado',
            array('route' => 'equipo_index')
        )->setExtra( 'icon', 'fa fa-circle-o');

        $menu['Equipos']->addChild(
            'Nuevo Equipo',
            array('route' => 'equipo_new')
        )->setExtra( 'icon', 'fa fa-circle-o');

        $menu->addChild(
            'Usuarios',
            array(
                'childrenAttributes' => array(
                    'class' => 'treeview-menu',
                ),
            )
        )
            ->setUri( '#' )
            ->setExtra( 'icon', 'fa fa-user' )
            ->setAttribute( 'class', 'treeview' );

        $menu['Usuarios']->addChild(
                'Listado',
                array('route' => 'persona_index')
            )->setExtra( 'icon', 'fa fa-circle-o');

        $menu['Usuarios']->addChild(
                'Nuevo Usuario',
                array('route' => 'persona_new')
            )->setExtra( 'icon', 'fa fa-circle-o');

        $menu->addChild(
            'Roles',
            array(
                'childrenAttributes' => array(
                    'class' => 'treeview-menu',
                ),
            )
        )
            ->setUri( '#' )
            ->setExtra( 'icon', 'fa fa-group' )
            ->setAttribute( 'class', 'treeview' );

        $menu['Roles']->addChild(
            'Listado',
            array('route' => 'rol_index')
        )->setExtra( 'icon', 'fa fa-circle-o');

        $menu['Roles']->addChild(
            'Nuevo Rol',
            array('route' => 'rol_new')
        )->setExtra( 'icon', 'fa fa-circle-o');
        //$menu->addChild('Usuarios')->addChild('listado', array('route' => 'persona_index'));
//
//// access services from the container!
//        $em = $this->container->get('doctrine')->getManager();
//// findMostRecent and Blog are just imaginary examples
//        $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();
//
//        $menu->addChild('Latest Blog Post', array(
//            'route' => 'blog_show',
//            'routeParameters' => array('id' => $blog->getId())
//        ));
//
//// create another menu item
//        $menu->addChild('About Me', array('route' => 'about'));
//// you can also add sub level's to your menu's as follows
//        $menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));
//
//// ... add more children

        return $menu;
    }
}