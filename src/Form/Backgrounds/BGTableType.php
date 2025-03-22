<?php

namespace App\Form\Backgrounds;

use App\Entity\Backgrounds\BGCarac;
use App\Entity\Backgrounds\BGSkill;
use App\Entity\Backgrounds\BGTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BGTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('name')
            ->add('skill', EntityType::class, [
                'class' => BGSkill::class,
                'choice_label' => 'id',
            ])
            ->add('bGCarac', EntityType::class, [
                'class' => BGCarac::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BGTable::class,
        ]);
    }
}
