<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstadisticaGeneralFechaFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('desde', DateType::class, array(
            'html5' => false,
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'attr' => array('class'=>'datepicker')

        ))->add('hasta', DateType::class, array(
            'html5' => false,
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'attr' => array('class'=>'datepicker')

        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_estadistica_general_fecha_filter_type';
    }
}
