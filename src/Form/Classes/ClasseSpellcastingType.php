<?php

namespace App\Form\Classes;

use App\Entity\Classes\ClasseLevel;
use App\Entity\Classes\ClasseSpellcasting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseSpellcastingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d')
            ->add('modifier')
            ->add('classeLevel', EntityType::class, [
                'class' => ClasseLevel::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseSpellcasting::class,
        ]);
    }
}
