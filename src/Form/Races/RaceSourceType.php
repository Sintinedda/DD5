<?php

namespace App\Form\Races;

use App\Entity\Assets\Language;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Races\RaceSource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceSourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d1', TextareaType::class, [
                'required' => false
            ])
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
            ->add('d3', TextareaType::class, [
                'required' => false
            ])
            ->add('ability', TextareaType::class, [
                'required' => false
            ])
            ->add('age', TextareaType::class, [
                'required' => false
            ])
            ->add('alignment', TextareaType::class, [
                'required' => false
            ])
            ->add('size', TextareaType::class, [
                'required' => false
            ])
            ->add('speed', TextareaType::class, [
                'required' => false
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'abbreviation',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'number',
                'required' => false
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'abbreviation',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceSource::class,
        ]);
    }
}
