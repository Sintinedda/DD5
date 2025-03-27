<?php

namespace App\Form\Monsters;

use App\Entity\Assets\Damage;
use App\Entity\Monsters\SBSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SBSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'skill' => 'skill',
                    'action' => 'action',
                    'reaction' => 'reaction',
                ]
            ])
            ->add('name', TextType::class)
            ->add('part', TextType::class, [
                'required' => false
            ])
            ->add('d', TextareaType::class, [
                'required' => false
            ])
            ->add('type_attack', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'w-cac' => 'w-cac',
                    'w-range' => 'w-range',
                ]
            ])
            ->add('target', TextType::class, [
                'required' => false
            ])
            ->add('damage', EntityType::class, [
                'class' => Damage::class,
                'choice_label' => 'abbreviation',
                'required' => false
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
