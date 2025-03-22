<?php

namespace App\Form\Classes;

use App\Entity\Classes\ClasseSkill;
use App\Entity\Classes\ClasseTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('name')
            ->add('skill', EntityType::class, [
                'class' => ClasseSkill::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseTable::class,
        ]);
    }
}
