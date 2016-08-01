<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NovedadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maniobra',null,array(
                'label' => 'Maniobra'
            ))
            ->add('inicio', DateTimeType::class, array(
                'html5' => false,
                'date_widget' => 'single_text',
                'date_format' => 'dd/MM/yyyy',
                'label' => 'Inicio'
            ))
            ->add('fin', DateTimeType::class, array(
                'html5' => false,
                'date_widget' => 'single_text',
                'date_format' => 'dd/MM/yyyy',
                'label' => 'Fin',
                'required' => false
            ))
            ->add('observaciones')
            ->add('parcialManiobra')
            ->add('promedioUh',null,array(
                'label' => 'Promedio U/H'
            ))
            ->add('generado',HiddenType::class)
            ->add('intervencion')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Novedad'
        ));
    }

}
