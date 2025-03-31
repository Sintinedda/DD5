<?php

namespace App\Form\Classes;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\SpecialtyItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialtyItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('part1', TextType::class, [
                'required' => false
            ])
            ->add('part2', TextType::class, [
                'required' => false
            ])
            ->add('ua')
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('d1', TextareaType::class, [
                'required' => false
            ])
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
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'abbreviation',
                'multiple' => true,
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'required' => false,
                'choice_label' => 'number',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpecialtyItem::class,
        ]);
    }
}
