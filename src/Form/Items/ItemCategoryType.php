<?php

namespace App\Form\Items;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('skills', EntityType::class, [
                'class' => ItemSkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemCategory::class,
        ]);
    }
}
