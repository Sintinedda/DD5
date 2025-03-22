<?php

namespace App\Form\Spells;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\Classe;
use App\Entity\Spells\Spell;
use App\Entity\Spells\SpellListe;
use App\Entity\Spells\SpellSchool;
use App\Entity\Spells\SpellTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpellType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug')
            ->add('name_fr')
            ->add('name_eng')
            ->add('level')
            ->add('ritual')
            ->add('casting')
            ->add('range1')
            ->add('range2')
            ->add('components')
            ->add('materials')
            ->add('duration')
            ->add('concentration')
            ->add('short')
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
            ->add('higher')
            ->add('school', EntityType::class, [
                'class' => SpellSchool::class,
                'choice_label' => 'id',
            ])
            ->add('classes', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('classes2', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'id',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'id',
            ])
            ->add('lists', EntityType::class, [
                'class' => SpellListe::class,
                'choice_label' => 'id',
            ])
            ->add('tables', EntityType::class, [
                'class' => SpellTable::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spell::class,
        ]);
    }
}
