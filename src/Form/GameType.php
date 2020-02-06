<?php

namespace App\Form;

use App\Entity\Game;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends ApplicationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->setConfiguration('Titre de votre partie', 'Donnez un titre à votre partie', 'h3', 'h2', true))
            ->add('shortDescription', TextType::class, $this->setConfiguration('Synopsis', 'Descrivez en quelques lignes le contexte de votre partie.', 'h3', 'h2', true))
            ->add('longDescription', CKEditorType::class, $this->setConfiguration('Description longue', 'Faite un description détaillé de votre partie,', 'h3', 'h2', true))
            ->add('gameBook', null, $this->setConfiguration('Image de couverture', 'Une image pour l\'entête de votre partie', 'h3', 'h2', true))
            ->add('vocalServer', null, $this->setConfiguration('Image de couverture', 'Une image pour l\'entête de votre partie', 'h3', 'h2', true))
            ->add('coverImage', UrlType::class, $this->setConfiguration('Image de couverture', 'Une image pour l\'entête de votre partie', 'h3', 'h2', true))
            ->add('gameSlides', CollectionType::class,
                [
                    'entry_type' => GameSlideType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add('gameBattleMaps', CollectionType::class,
                [
                    'entry_type' => GameBattleMapType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add('gameImages', CollectionType::class,
                [
                    'entry_type' => GameImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
