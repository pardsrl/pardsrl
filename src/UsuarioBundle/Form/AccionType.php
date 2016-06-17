<?php

namespace UsuarioBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccionType extends AbstractType
{

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $routesCollection = $this->router->getRouteCollection();

        $rutas = array();

        foreach ($routesCollection->all() as $routeName => $route) {
            if ($route->hasDefault('_controller') && !preg_match("/^(_|fos|root)/", $routeName)) {
                $rutas[$routeName] = $routeName;
            }

        }

        asort($rutas);

        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('ruta',ChoiceType::class,array(
                'choices' => $rutas,
                'choices_as_values' => true
            ))
            ->add('activo')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsuarioBundle\Entity\Accion'
        ));
    }
}
