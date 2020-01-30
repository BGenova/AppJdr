<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends  ApplicationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->setConfiguration("Prenom * ","Veuillez entrez votre prenom","h5","form-control",true))
            ->add('lastName',TextType::class,$this->setConfiguration("Nom *","Veuillez entrez votre nom","h5","form-control",true))
            ->add('nickName',TextType::class,$this->setConfiguration("Pseudo *","Veuillez entrez votre pseudo","h5","form-control",true))
            ->add('email',EmailType::class,$this->setConfiguration("Email *","Veuillez entrez votre adresse email","h5","form-control",true))
//            ->add('picture',TextType::class,$this->setConfiguration("Avatar","Veuillez entrez l'Url de votre avatar","h5","form-control",false))
            ->add('hash',PasswordType::class,$this->setConfiguration("Mot de passe *","Veuillez entrez un mot de passe","h5","form-control",true))
            ->add('passwordConfirm',PasswordType::class,$this->setConfiguration("Veuillez confirmez votre mot de passe *","Entrez un mot de passe","h5","form-control",true))
//            ->add('shortdescription',TextType::class,$this->setConfiguration("Introduction","Veuillez entrez votre introduction","h5","form-control",false))
//            ->add('longDescription',TextareaType::class,$this->setConfiguration("Description","Veuillez entrez votre description","h5","form-control",false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
