<?php

namespace App\Form\Items;

use App\Entity\Classes\Classe;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemListe;
use App\Entity\Items\ItemSkill;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Items\ItemTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemSubcategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('place')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('category', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'id',
            ])
            ->add('skills', EntityType::class, [
                'class' => ItemSkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tables', EntityType::class, [
                'class' => ItemTable::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('listes', EntityType::class, [
                'class' => ItemListe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemSubcategory::class,
        ]);
    }
}
