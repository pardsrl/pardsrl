<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use UsuarioBundle\Entity\Menu;
use UsuarioBundle\Services\SecurityManager;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $this->usuario = $this->container->get('security.token_storage')->getToken()->getUser();

        $this->securityManager = $this->container->get('security.manager');

        $em = $this->container->get('doctrine')->getManager();

        $misEquipos = $this->usuario->getPersona()->getEquiposActivos();

        $roles = $this->usuario->getRoles();

        $this->rol = $roles[0];

        $menu = $factory->createItem(
            'root',
            array(
                'childrenAttributes' => array(
                    'class' => 'sidebar-menu',
                ),
            )
        );


        if ($this->securityManager->isGranted($this->rol, 'dashboard') || $this->usuario->hasRole('ROLE_SUPER_ADMIN')) {
            $menu->addChild('Dashboard', array('route' => 'dashboard'))->setExtra('icon', 'fa fa-area-chart');
        }

        //TODO siempre se están generando estas rutas si el usuario tiene asignado equipos

        if ($misEquipos->count()) {
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

        $itemsQuery = $em->getRepository('UsuarioBundle:Menu')->getRootsActivos()->getQuery();

        $items = $itemsQuery->getResult();


        foreach ($items as $item) {

            $this->generaMenu($item, $menu);
        }

        return $menu;
    }


    public function generaMenu(Menu $nodoRaiz, $menuBuilder)
    {


        if ($nodoRaiz->tieneHijosActivos()) {

            $esHeader = $nodoRaiz->esHeader();

            if ($esHeader) {

                $menuBuilder->addChild(strtoupper($nodoRaiz->getNombre()))->setAttribute('class', 'header');
            } else {
                $menuBuilder->addChild(
                    $nodoRaiz->getNombre(),
                    array(
                        'childrenAttributes' => array(
                            'class' => 'treeview-menu',
                        ),
                    )
                )
                    ->setUri('#')
                    ->setExtra('icon', 'fa ' . $nodoRaiz->getClaseIcono())
                    ->setAttribute('class', 'treeview');
            }

            foreach ($nodoRaiz->getHijosActivos() as $item) {

                $this->generaMenu($item, $menuBuilder);
            }

            if (!$esHeader) {
                if (!$menuBuilder->getChild($nodoRaiz->getNombre())->hasChildren()) {
                    $menuBuilder->removeChild($nodoRaiz->getNombre());
                }
            } else {

                $ultimoNodo = $menuBuilder->getLastChild()->getName();

                if ($ultimoNodo == strtoupper($nodoRaiz->getNombre())) {
                    $menuBuilder->removeChild($ultimoNodo);
                }
            }


        } else {

            if ($nodoRaiz->esLink()) {

                if ($nodoRaiz->getPadre()) {
                    $menuBuilder = $menuBuilder[$nodoRaiz->getPadre()->getNombre()];
                }

                $ruta = $nodoRaiz->getAccion()->getRuta();

                if ($this->securityManager->isGranted($this->rol,
                        $ruta) || $this->usuario->hasRole('ROLE_SUPER_ADMIN')
                ) {
                    $menuBuilder->addChild($nodoRaiz->getNombre(), array('route' => $ruta))->setExtra('icon',
                        'fa ' . $nodoRaiz->getClaseIcono());
                }
            }
        }
    }
}