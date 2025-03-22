<?php

namespace App\Form\Classes;

use App\Entity\Classes\SpecialtyItem;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Classes\SpecialtyTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialtyTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('name')
            ->add('skill', EntityType::class, [
                'class' => SpecialtySkill::class,
                'choice_label' => 'id',
            ])
            ->add('specialties', EntityType::class, [
                'class' => SpecialtyItem::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpecialtyTable::class,
        ]);
    }
}
