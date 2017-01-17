<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecursoFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('recurso', ChoiceType::class, array(
	        	'empty_value' => '-- Seleccione un recurso --',
	            'required' => false,
		        'choices'  =>$options['recursos']
	        ))
	        ->add('objetoId',NumberType::class, array(
	        	'label'    => 'Id',
 		        'required' => false
	        ))
	        ->add('nombreArchivo',null, array(
		        'required' => false
	        ))
	        ->add('extension', ChoiceType::class, array(
		        'empty_value' => '-- Seleccione una extensión --',
		        'required' => false,
		        'choices'  =>$options['extensiones']
	        ))
	        //->add('activo')
	        ->add('fechaCreacion',DateType::class,array(
	        	'widget' => 'single_text',
		        'format' => 'dd/MM/yyyy',
		        'html5' => false,
		        'required' => false,
	        	'attr' => array('class'=>'datepicker')
	        ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        	'csrf_protection' => false,
	        'recursos' => array(),
	        'extensiones' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recurso';
    }


}
