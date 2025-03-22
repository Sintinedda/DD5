<?php

namespace App\Form\Races;

use App\Entity\Assets\Language;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Races\Race;
use App\Entity\Races\RaceSkill;
use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceSourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('ability')
            ->add('age')
            ->add('alignment')
            ->add('size')
            ->add('speed')
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'id',
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'id',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'id',
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('skills', EntityType::class, [
                'class' => RaceSkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tables', EntityType::class, [
                'class' => RaceTable::class,
                'choice_label' => 'id',
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
