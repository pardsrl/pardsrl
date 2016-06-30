<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UsuarioBundle\Form\UsuarioType;

class PersonaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('sexo', ChoiceType::class, array(
                'choices' => array(
                    'Masculino' => 'M' ,
                    'Femenino'  => 'F'
                ),
                'choices_as_values' => true
            ))
            ->add('telefonoPrincipal')
            ->add('telefonoSecundario')
            ->add('cargo')
            ->add('usuario', UsuarioType::class, array())
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Persona'
        ));
    }
}
