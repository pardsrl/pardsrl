<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use UsuarioBundle\Entity\Menu;
use UsuarioBundle\Services\SecurityManager;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {

	    $menu = $factory->createItem(
		    'root',
		    array(
			    'childrenAttributes' => array(
				    'class' => 'sidebar-menu',
			    ),
		    )
	    );

	    $token = $this->container->get('security.token_storage')->getToken();

	    //si existe un token de usuario
	    if($token) {


		    $this->usuario = $token->getUser();

		    $this->securityManager = $this->container->get( 'security.manager' );

		    $em = $this->container->get( 'doctrine' )->getManager();

		    $misEquipos = $this->usuario->getPersona()->getEquiposActivos();

		    $roles = $this->usuario->getRoles();

		    $this->rol = $roles[0];


		    if ( $this->securityManager->isGranted( $this->rol,
				    'dashboard' ) || $this->usuario->hasRole( 'ROLE_SUPER_ADMIN' )
		    ) {
			    $menu->addChild( 'Dashboard', array( 'route' => 'dashboard' ) )->setExtra( 'icon', 'fa fa-area-chart' );
		    }

		    //TODO siempre se están generando estas rutas si el usuario tiene asignado equipos

		    if ( $misEquipos->count() ) {
			    $menu->addChild( 'MIS EQUIPOS' )->setAttribute( 'class', 'header' );

			    foreach ( $misEquipos as $equipo ) {

				    $menu->addChild(
					    strtoupper( $equipo->getNombreCompleto() ),
					    array(
						    'childrenAttributes' => array(
							    'class' => 'treeview-menu',
						    ),
					    )
				    )
				         ->setUri( '#' )
				         ->setExtra( 'icon', 'fa fa-circle-o text-aqua' )
				         ->setAttribute( 'class', 'treeview' );

				    $menu[ strtoupper( $equipo->getNombreCompleto() ) ]->addChild(
					    'Gráficas',
					    array( 'route' => 'equipo_graficas', 'routeParameters' => array( 'id' => $equipo->getId() ) )
				    )->setExtra( 'icon', 'fa fa-bar-chart' );

				    $menu[ strtoupper( $equipo->getNombreCompleto() ) ]->addChild(
					    'Instrumentos',
					    array( 'route'           => 'equipo_instrumentos',
					           'routeParameters' => array( 'id' => $equipo->getId() )
					    )
				    )->setExtra( 'icon', 'fa  fa-cogs' );

				    $menu[ strtoupper( $equipo->getNombreCompleto() ) ]->addChild(
					    'Estadística Actual',
					    array( 'route'           => 'equipo_estadisticas',
					           'routeParameters' => array( 'id' => $equipo->getId() )
					    )
				    )->setExtra( 'icon', 'fa  fa-line-chart' );

				    $menu[ strtoupper( $equipo->getNombreCompleto() ) ]->addChild(
					    'Estadísticas Individuales',
					    array( 'route'           => 'equipo_estadisticas_individuales',
					           'routeParameters' => array( 'id' => $equipo->getId() )
					    )
				    )->setExtra( 'icon', 'fa  fa-line-chart' );

				    $menu[ strtoupper( $equipo->getNombreCompleto() ) ]->addChild(
					    'Registra Novedades',
					    array( 'route' => 'novedad_nueva', 'routeParameters' => array( 'id' => $equipo->getId() ) )
				    )->setExtra( 'icon', 'fa  fa-bell-o' );

				    $intervencionActual = $equipo->getIntervencionActual();

				    if($intervencionActual){

				    	$lat = $intervencionActual->getPozo()->getLatitud();

				    	$lng = $intervencionActual->getPozo()->getLongitud();

				    	$protocol = 'http';

				    	if($this->isMobile($this->container->get('request'))){
						    $protocol = 'map';
					    }

					    $menu[ strtoupper( $equipo->getNombreCompleto() ) ]->addChild(
						    'Ver en Google Maps',
						    array( 'uri' => "$protocol://maps.google.com?q=$lat,$lng" )
					    )->setExtra( 'icon', 'fa  fa-map-pin' )
					     ->setLinkAttributes(array('target'=>'_blank'));
				    }


			    }
		    }

		    //Se genera  el resto del menu desde la tabla usr_menu

		    $itemsQuery = $em->getRepository( 'UsuarioBundle:Menu' )->getRootsActivos()->getQuery();

		    $items = $itemsQuery->getResult();


		    foreach ( $items as $item ) {

			    $this->generaMenu( $item, $menu );
		    }

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


    private function isMobile(Request $request)
    {
	    $useragent = $request->headers->get('User-Agent');
	    if (!$useragent) {
		    return false;
	    }

	    return (
		    preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) ||
		    preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent,0,4))
	    );
    }
}