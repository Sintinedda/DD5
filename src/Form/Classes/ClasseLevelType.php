<?php

namespace App\Form\Classes;

use App\Entity\Classes\Classe;
use App\Entity\Classes\ClasseLevel;
use App\Entity\Classes\ClasseSkill;
use App\Entity\Classes\ClasseSpellcasting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level')
            ->add('bm')
            ->add('cantrip_know')
            ->add('spell_know')
            ->add('s1')
            ->add('s2')
            ->add('s3')
            ->add('s4')
            ->add('s5')
            ->add('s6')
            ->add('s7')
            ->add('s8')
            ->add('s9')
            ->add('infusion_know')
            ->add('infused_item')
            ->add('rage')
            ->add('rage_damage')
            ->add('martial_art')
            ->add('ki')
            ->add('unarmored_move')
            ->add('sneak_attack')
            ->add('sorcery_point')
            ->add('spell_slot')
            ->add('slot_level')
            ->add('invocation_know')
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'id',
            ])
            ->add('skills', EntityType::class, [
                'class' => ClasseSkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('spellcasting', EntityType::class, [
                'class' => ClasseSpellcasting::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseLevel::class,
        ]);
    }
}
