<?php

namespace App\Form\Monsters;

use App\Entity\Assets\Alignment;
use App\Entity\Assets\CreatureType;
use App\Entity\Assets\Sense;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Assets\Speed;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Monsters\SB;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_fr', TextType::class)
            ->add('name_eng', TextType::class)
            ->add('slug', TextType::class)
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Monstres' => 'Monstres',
                    'Animaux' => 'Animaux',
                    'PNJ' => 'PNJ',
                ]
            ])
            ->add('type2', TextType::class, [
                'required' => false
            ])
            ->add('sizes', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'choices' => [
                    'TP' => 'TP', 
                    'P' => 'P', 
                    'M' => 'M', 
                    'G' => 'G', 
                    'TG' => 'TG', 
                    'Gig' => 'Gig', 
                ]
            ])
            ->add('size_inf')
            ->add('size_sup')
            ->add('ca', IntegerType::class, [
                'required' => false
            ])
            ->add('armor', TextType::class, [
                'required' => false
            ])
            ->add('pv', IntegerType::class, [
                'required' => false
            ])
            ->add('dv', TextType::class, [
                'required' => false
            ])
            ->add('speeds', EntityType::class, [
                'class' => Speed::class,
                'choice_label' => 'abbreviation',
                'required' => false,
                'multiple' => true,
            ])
            ->add('strenght', IntegerType::class, [
                'required' => false
            ])
            ->add('dexterity', IntegerType::class, [
                'required' => false
            ])
            ->add('constitution', IntegerType::class, [
                'required' => false
            ])
            ->add('intelligence', IntegerType::class, [
                'required' => false
            ])
            ->add('wisdow', IntegerType::class, [
                'required' => false
            ])
            ->add('charisma', IntegerType::class, [
                'required' => false
            ])
            ->add('save', TextType::class, [
                'required' => false
            ])
            ->add('competence', TextType::class, [
                'required' => false
            ])
            ->add('pp', IntegerType::class, [
                'required' => false
            ])
            ->add('pp2', TextType::class, [
                'required' => false
            ])
            ->add('fp', NumberType::class, [
                'required' => false
            ])
            ->add('xp', IntegerType::class, [
                'required' => false
            ])
            ->add('bm', TextType::class, [
                'required' => false
            ])
            ->add('d', TextareaType::class, [
                'required' => false
            ])
            ->add('cac_t', TextType::class, [
                'required' => false
            ])
            ->add('cac_r', TextType::class, [
                'required' => false
            ])
            ->add('cac_d', TextType::class, [
                'required' => false
            ])
            ->add('range_t', TextType::class, [
                'required' => false
            ])
            ->add('range_r', TextType::class, [
                'required' => false
            ])
            ->add('range_d', TextType::class, [
                'required' => false
            ])
            ->add('type', EntityType::class, [
                'class' => CreatureType::class,
                'choice_label' => 'name',
            ])
            ->add('sens', EntityType::class, [
                'class' => Sense::class,
                'choice_label' => 'abbreviation',
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
            ->add('alignment', EntityType::class, [
                'class' => Alignment::class,
                'choice_label' => 'abbreviation',
                'required' => false
            ])
            ->add('specialties', EntityType::class, [
                'class' => SpecialtySkill::class,
                'multiple' => true,
                'choice_label' => 'name',
                'required' => false,
                'group_by' => function($item) {
                    return $item->getSpecialty()[0]->getSlug();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SB::class,
        ]);
    }
}
