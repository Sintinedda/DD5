<?php

namespace App\Form\Items;

use App\Entity\Items\Item;
use App\Entity\Items\ItemSkill;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Items\ItemTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('name')
            ->add('skill', EntityType::class, [
                'class' => ItemSkill::class,
                'choice_label' => 'id',
            ])
            ->add('subcategories', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('items', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemTable::class,
        ]);
    }
}
