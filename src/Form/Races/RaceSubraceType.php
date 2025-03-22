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

class RaceSubraceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug')
            ->add('name')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('ability')
            ->add('source', EntityType::class, [
                'class' => RaceSource::class,
                'choice_label' => 'id',
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
            'data_class' => RaceSubrace::class,
        ]);
    }
}
