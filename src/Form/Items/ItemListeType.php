<?php

namespace App\Form\Items;

use App\Entity\Items\ItemListe;
use App\Entity\Items\ItemSkill;
use App\Entity\Items\ItemSubcategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('place')
            ->add('l1')
            ->add('l2')
            ->add('l3')
            ->add('l4')
            ->add('l5')
            ->add('l6')
            ->add('l7')
            ->add('l8')
            ->add('l9')
            ->add('l10')
            ->add('skill', EntityType::class, [
                'class' => ItemSkill::class,
                'choice_label' => 'id',
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
            'data_class' => ItemListe::class,
        ]);
    }
}
