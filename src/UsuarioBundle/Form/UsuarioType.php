<?php

namespace UsuarioBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $roles = $this->em->getRepository('UsuarioBundle:Rol')->findAll();

        $aRoles = array();

        foreach ($roles as $rol) {
            $aRoles[$rol->getSlug()] = $rol->getNombre();
        }


        $builder
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => array('placeholder'=> 'Email')
            ))
            ->add('username', null, array(
                'label' => false,
                'attr' => array('placeholder'=> 'Nombre de Usuario')
            ))
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
                'mapped' => false
            ));
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

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
}
