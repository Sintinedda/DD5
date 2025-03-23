<?php

namespace App\Form\Backgrounds;

use App\Entity\Backgrounds\BGSkill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BGSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BGSkill::class,
        ]);
    }
}
