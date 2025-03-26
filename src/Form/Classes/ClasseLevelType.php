<?php

namespace App\Form\Classes;

use App\Entity\Classes\ClasseLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level', IntegerType::class)
            ->add('bm', IntegerType::class)
            ->add('cantrip_know', IntegerType::class, [
                'required' => false
            ])
            ->add('spell_know', IntegerType::class, [
                'required' => false
            ])
            ->add('s1', IntegerType::class, [
                'required' => false
            ])
            ->add('s2', IntegerType::class, [
                'required' => false
            ])
            ->add('s3', IntegerType::class, [
                'required' => false
            ])
            ->add('s4', IntegerType::class, [
                'required' => false
            ])
            ->add('s5', IntegerType::class, [
                'required' => false
            ])
            ->add('s6', IntegerType::class, [
                'required' => false
            ])
            ->add('s7', IntegerType::class, [
                'required' => false
            ])
            ->add('s8', IntegerType::class, [
                'required' => false
            ])
            ->add('s9', IntegerType::class, [
                'required' => false
            ])
            ->add('infusion_know', IntegerType::class, [
                'required' => false
            ])
            ->add('infused_item', IntegerType::class, [
                'required' => false
            ])
            ->add('rage', IntegerType::class, [
                'required' => false
            ])
            ->add('rage_damage', IntegerType::class, [
                'required' => false
            ])
            ->add('martial_art', IntegerType::class, [
                'required' => false
            ])
            ->add('ki', IntegerType::class, [
                'required' => false
            ])
            ->add('unarmored_move', IntegerType::class, [
                'required' => false
            ])
            ->add('sneak_attack', IntegerType::class, [
                'required' => false
            ])
            ->add('sorcery_point', IntegerType::class, [
                'required' => false
            ])
            ->add('spell_slot', IntegerType::class, [
                'required' => false
            ])
            ->add('slot_level', IntegerType::class, [
                'required' => false
            ])
            ->add('invocation_know', IntegerType::class, [
                'required' => false
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
