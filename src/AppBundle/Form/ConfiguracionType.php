<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    	$configuracion = $options['data'];

//	    dump($configuracion);

        $builder
//	        ->add('configuracion')
	        ->add('historicoPozo',CheckboxType::class,array(
	        	'mapped'   => false,
		        'required' => false,
		        'data'     => $configuracion->getConfig('historicoPozo')
	        ))
	        ->add('historicoManiobras',CheckboxType::class,array(
	        	'mapped' => false,
		        'required' => false,
		        'data'     => $configuracion->getConfig('historicoManiobras')
	        ))
	        ->add('tiempoRealPozo',CheckboxType::class,array(
	        	'mapped' => false,
		        'required' => false,
		        'data'     => $configuracion->getConfig('tiempoRealPozo')
	        ))
	        ->add('tiempoRealManiobras',CheckboxType::class,array(
	        	'mapped' => false,
		        'required' => false,
		        'data'     => $configuracion->getConfig('tiempoRealManiobras')
	        ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Configuracion',
	        'doctrine'   => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_configuracion';
    }


}
