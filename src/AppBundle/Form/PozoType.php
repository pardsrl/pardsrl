<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PozoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yacimiento')
            ->add('nombre')
            ->add('acronimo')
            ->add('profundidad')
            ->add('sistemaExtraccion',ChoiceType::class,array(
                'choices' => array(
                    "AIB" => "AIB" ,
                     "PcP" => "PcP",
                     "BES" => "BES",
                     "NINGUNO" => ""
                ),
                'choices_as_values' => true,
                'label' => 'Sistema de extracción'
            ))
            ->add('latitud')
            ->add('longitud')
            ->add('activo')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pozo'
        ));
    }
}
