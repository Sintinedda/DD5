<?php

namespace App\Form\Items;

use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSkill;
use App\Entity\Items\ItemSubcategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level')
            ->add('show_skill')
            ->add('optional')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('d6')
            ->add('d7')
            ->add('d8')
            ->add('d9')
            ->add('d10')
            ->add('itemCategories', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('subcategories', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemSkill::class,
        ]);
    }
}
