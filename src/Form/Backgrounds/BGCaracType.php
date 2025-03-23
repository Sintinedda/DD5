<?php

namespace App\Form\Backgrounds;

use App\Entity\Backgrounds\BGCarac;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BGCaracType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d1', TextareaType::class, [
                'required' => false
            ])
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
            ->add('d3', TextareaType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BGCarac::class,
        ]);
    }
}
