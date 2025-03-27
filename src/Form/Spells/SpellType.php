<?php

namespace App\Form\Spells;

use App\Entity\Assets\School;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\Classe;
use App\Entity\Spells\Spell;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpellType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug', TextType::class)
            ->add('name_fr', TextType::class)
            ->add('name_eng', TextType::class)
            ->add('level', ChoiceType::class, [
                'choices' => [
                    0 => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                ]
            ])
            ->add('ritual')
            ->add('casting', TextType::class)
            ->add('range1', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    '' => '',
                ]
            ])
            ->add('range2', TextType::class, [
                'required' => false
            ])
            ->add('components', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'V' => 'V',
                    'S' => 'S',
                    'M' => 'M'
                ]
            ])
            ->add('materials', TextType::class, [
                'required' => false
            ])
            ->add('duration', TextType::class)
            ->add('concentration')
            ->add('short', TextareaType::class)
            ->add('d1', TextareaType::class)
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
            ->add('d3', TextareaType::class, [
                'required' => false
            ])
            ->add('d4', TextareaType::class, [
                'required' => false
            ])
            ->add('d5', TextareaType::class, [
                'required' => false
            ])
            ->add('d6', TextareaType::class, [
                'required' => false
            ])
            ->add('d7', TextareaType::class, [
                'required' => false
            ])
            ->add('d8', TextareaType::class, [
                'required' => false
            ])
            ->add('d9', TextareaType::class, [
                'required' => false
            ])
            ->add('d10', TextareaType::class, [
                'required' => false
            ])
            ->add('higher', TextareaType::class, [
                'required' => false
            ])
            ->add('school', EntityType::class, [
                'class' => School::class,
                'choice_label' => 'slug',
            ])
            ->add('classes', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'slug',
                'multiple' => true,
            ])
            ->add('classes2', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'slug',
                'multiple' => true,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spell::class,
        ]);
    }
}
