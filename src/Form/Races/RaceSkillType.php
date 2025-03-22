<?php

namespace App\Form\Races;

use App\Entity\Races\RaceSkill;
use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceSubrace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level')
            ->add('show_skill')
            ->add('optional')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('d6')
            ->add('d7')
            ->add('d8')
            ->add('d9')
            ->add('d10')
            ->add('part')
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
            'data_class' => RaceSkill::class,
        ]);
    }
}
