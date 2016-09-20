<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MensajeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mensaje')
            ->add('destacado')
            ->add('archivado')
            ->add('activo')
            ->add('fechaCreacion', 'datetime')
            ->add('fechaActualizacion', 'datetime')
            ->add('distribucion')
            ->add('creadoPor')
            ->add('actualizadoPor')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Mensaje'
        ));
    }
}
