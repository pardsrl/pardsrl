<?php

namespace UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class FuncionalidadRolType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('funcionalidad')
            ->add('rol',null,array(
                'data' => $options['rol']
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $funcionalidadRol = $event->getData();

            $form = $event->getForm();

            // chequeo si la funcionalidad accion es nueva
            if (!$funcionalidadRol || null === $funcionalidadRol->getId()) {
                $data = true;
            }else{
                $data = $funcionalidadRol->getActivo();
            }

            $form->add('activo', CheckboxType::class, array(
                'data' => $data,
                'required' => false
            ));
        });
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsuarioBundle\Entity\FuncionalidadRol',
            'constraints' => new Valid()
        ));

        $resolver->setRequired(array('rol'));

    }
}
