<?php

namespace App\Form\Construct;

use App\Entity\Construct\TableRow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', IntegerType::class)
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TableRow::class,
        ]);
    }
}
