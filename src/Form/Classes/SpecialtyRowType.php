<?php

namespace App\Form\Classes;

use App\Entity\Classes\SpecialtyRow;
use App\Entity\Classes\SpecialtyTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialtyRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('d6')
            ->add('d7')
            ->add('d8')
            ->add('tableau', EntityType::class, [
                'class' => SpecialtyTable::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpecialtyRow::class,
        ]);
    }
}
