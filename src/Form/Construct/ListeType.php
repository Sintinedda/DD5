<?php

namespace App\Form\Construct;

use App\Entity\Construct\Liste;
use App\Entity\Construct\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('l1')
            ->add('l2')
            ->add('l3')
            ->add('l4')
            ->add('l5')
            ->add('l6')
            ->add('l7')
            ->add('l8')
            ->add('l9')
            ->add('l10')
            ->add('skill', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Liste::class,
        ]);
    }
}
