<?php

namespace App\Form\Construct;

use App\Entity\Construct\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('level', IntegerType::class, [
                'required' => false
            ])
            ->add('show_skill')
            ->add('optional')
            ->add('part', TextType::class, [
                'required' =>false
            ])
            ->add('d1', TextareaType::class, [
                'required' =>false
            ])
            ->add('d2', TextareaType::class, [
                'required' =>false
            ])
            ->add('d3', TextareaType::class, [
                'required' =>false
            ])
            ->add('d4', TextareaType::class, [
                'required' =>false
            ])
            ->add('d5', TextareaType::class, [
                'required' =>false
            ])
            ->add('d6', TextareaType::class, [
                'required' =>false
            ])
            ->add('d7', TextareaType::class, [
                'required' =>false
            ])
            ->add('d8', TextareaType::class, [
                'required' =>false
            ])
            ->add('d9', TextareaType::class, [
                'required' =>false
            ])
            ->add('d10', TextareaType::class, [
                'required' =>false
            ])
            ->add('lvls', ChoiceType::class, [
                'multiple' => true,
                'mapped' => false,
                'choices' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    10 => 10,
                    11 => 11,
                    12 => 12,
                    13 => 13,
                    14 => 14,
                    15 => 15,
                    16 => 16,
                    17 => 17,
                    18 => 18,
                    19 => 19,
                    20 => 20
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
