<?php

namespace App\Form\Items;

use App\Entity\Assets\Damage;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\Classe;
use App\Entity\Items\Item;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemProperty;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Items\ItemTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('quantity')
            ->add('rarity')
            ->add('type')
            ->add('cost')
            ->add('weight')
            ->add('ca')
            ->add('ca_dex')
            ->add('ca_max')
            ->add('ca_str')
            ->add('ca_stealth')
            ->add('ca_don')
            ->add('ca_doff')
            ->add('dice')
            ->add('link')
            ->add('damage')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('armorclasses', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('weaponclasses', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('toolclasses', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('subcategory', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'id',
            ])
            ->add('category', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'id',
            ])
            ->add('damage2', EntityType::class, [
                'class' => Damage::class,
                'choice_label' => 'id',
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'id',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'id',
            ])
            ->add('tables', EntityType::class, [
                'class' => ItemTable::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('properties', EntityType::class, [
                'class' => ItemProperty::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
