<?php

namespace App\Form\Monsters;

use App\Entity\Monsters\SB;
use App\Entity\Monsters\SBSkill;
use App\Entity\Monsters\SBSpecialty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SBSpecialtyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d')
            ->add('monster', EntityType::class, [
                'class' => SB::class,
                'choice_label' => 'id',
            ])
            ->add('skill', EntityType::class, [
                'class' => SBSkill::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SBSpecialty::class,
        ]);
    }
}
