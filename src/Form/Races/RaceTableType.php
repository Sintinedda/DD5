<?php

namespace App\Form\Races;

use App\Entity\Races\RaceSkill;
use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceSubrace;
use App\Entity\Races\RaceTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('name')
            ->add('skill', EntityType::class, [
                'class' => RaceSkill::class,
                'choice_label' => 'id',
            ])
            ->add('sources', EntityType::class, [
                'class' => RaceSource::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('subraces', EntityType::class, [
                'class' => RaceSubrace::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceTable::class,
        ]);
    }
}
