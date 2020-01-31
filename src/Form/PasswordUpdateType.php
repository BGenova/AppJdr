<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->setConfiguration("Ancien mot de passe","Ancien mot de passe","h3","text-center",true))
            ->add('newPassword', PasswordType::class, $this->setConfiguration("Nouveau mot de passe","Nouveau mot de passe","h3","text-center",true))
            ->add('confirmPassword', PasswordType::class, $this->setConfiguration("Confirmer mot de passe","Confirmer mot de passe","h3","text-center",true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
