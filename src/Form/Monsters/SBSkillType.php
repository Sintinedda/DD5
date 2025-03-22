<?php

namespace App\Form\Monsters;

use App\Entity\Assets\Damage;
use App\Entity\Monsters\SB;
use App\Entity\Monsters\SBSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SBSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('name')
            ->add('part')
            ->add('d')
            ->add('type_attack')
            ->add('target')
            ->add('monsters', EntityType::class, [
                'class' => SB::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('damage', EntityType::class, [
                'class' => Damage::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SBSkill::class,
        ]);
    }
}
