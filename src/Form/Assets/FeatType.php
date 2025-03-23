<?php

namespace App\Form\Assets;

use App\Entity\Assets\Feat;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('prerequisite', TextType::class)
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'abbreviation',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'number',
                'required' => false
            ])
            ->add('d1', TextareaType::class)
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
            ->add('d3', TextareaType::class, [
                'required' => false
            ])
            ->add('d4', TextareaType::class, [
                'required' => false
            ])
            ->add('d5', TextareaType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feat::class,
        ]);
    }
}
