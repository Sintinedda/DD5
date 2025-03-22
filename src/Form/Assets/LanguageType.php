<?php

namespace App\Form\Assets;

use App\Entity\Assets\Language;
use App\Entity\Backgrounds\BG;
use App\Entity\Races\RaceSource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('bGs', EntityType::class, [
                'class' => BG::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('races', EntityType::class, [
                'class' => RaceSource::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
        ]);
    }
}
