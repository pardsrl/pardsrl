<?php

namespace UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Collection;

class FuncionalidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('activo');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $funcionalidad = $event->getData();

            $form = $event->getForm();

            // chequeo si la funcionalidad es nueva
            if ($funcionalidad->getId()) {
                $form->add('funcionalidadesAccion', CollectionType::class, array(
                    'entry_type' => FuncionalidadAccionType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options' => array(
                        'funcionalidad' => $funcionalidad
                    )
                ));
            }
        });

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsuarioBundle\Entity\Funcionalidad'
        ));
    }
}
