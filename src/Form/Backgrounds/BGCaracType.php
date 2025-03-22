<?php

namespace App\Form\Backgrounds;

use App\Entity\Backgrounds\BG;
use App\Entity\Backgrounds\BGCarac;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BGCaracType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('bg', EntityType::class, [
                'class' => BG::class,
                'choice_label' => 'id',
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
