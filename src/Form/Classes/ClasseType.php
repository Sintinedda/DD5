<?php

namespace App\Form\Classes;

use App\Entity\Assets\Competence;
use App\Entity\Classes\Classe;
use App\Entity\Classes\Specialty;
use App\Entity\Items\Item;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Spells\Spell;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('d')
            ->add('dv')
            ->add('save')
            ->add('ManyToMany')
            ->add('equipment1')
            ->add('equipment2')
            ->add('equipment3')
            ->add('equipment4')
            ->add('armor1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('weapon1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tool1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tool2', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'id',
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('specialty', EntityType::class, [
                'class' => Specialty::class,
                'choice_label' => 'id',
            ])
            ->add('armor2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('weapon2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('spells', EntityType::class, [
                'class' => Spell::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('spells2', EntityType::class, [
                'class' => Spell::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
