<?php

namespace UsuarioBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => array('placeholder'=> 'Email')
            ))
            ->add('username', null, array(
                'label' => false,
                'attr' => array('placeholder'=> 'Nombre de Usuario')
            ))
            ;



        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $usuario = $event->getData();

            $form = $event->getForm();

            $roles   = $this->em->getRepository('UsuarioBundle:Rol')->findAll();

            $aRoles = array();

            foreach ($roles as $rol) {
                $aRoles[$rol->getNombre()] = $rol->getSlug();
            }

            // check if the Usuario object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Usuario"
            if (!$usuario || null === $usuario->getId()) {

                $form
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => false,'attr' => array('placeholder'=>'contraseña')),
                    'second_options' => array('label' => false,'attr' => array('placeholder'=>'Repita la contraseña')),
                    'invalid_message' => 'Las contraseñas ingresadas no coinciden',
                ))
                ->add('roles',ChoiceType::class,array(
                    'choices' => $aRoles,
                    'label' => 'Rol',
                    'expanded' => true,
                    'choices_as_values'=> true,
                    'mapped' => false
                ))
                ->add('enabled', null, array(
                    'label' => 'Habilitado'
                ));

            }else{

                $roles = $usuario->getRoles();

                // deseteo el ROL por defecto que agrega FOS_USER
                unset($roles[1]);

                $form->add('roles',ChoiceType::class,array(
                    'choices'  => $aRoles,
                    'data'     => $roles[0],
                    'label'    => 'Rol',
                    'choices_as_values'=> true,
                    'expanded' => true,
                    'mapped'   => false
                ))
                ->add('enabled', null, array(
                    'label' => 'Habilitado'
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
            'data_class' => 'UsuarioBundle\Entity\Usuario',
            'error_bubbling' => true
        ));
    }

//    public function getParent()
//    {
//        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
//    }
}
