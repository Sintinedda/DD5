<?php

namespace App\Form\Classes;

use App\Entity\Classes\ClasseSkill;
use App\Entity\Classes\ClasseSubskill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseSubskillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('t1')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('skill', EntityType::class, [
                'class' => ClasseSkill::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseSubskill::class,
        ]);
    }
}
