<?php

namespace App\Form\Assets;

use App\Entity\Assets\Source;
use App\Entity\Classes\SpecialtyItem;
use App\Entity\Items\ItemCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('abbreviation')
            ->add('specialties', EntityType::class, [
                'class' => SpecialtyItem::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('itemCategories', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Source::class,
        ]);
    }
}
