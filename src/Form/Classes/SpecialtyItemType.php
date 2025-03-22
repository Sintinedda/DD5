<?php

namespace App\Form\Classes;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\Specialty;
use App\Entity\Classes\SpecialtyItem;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Classes\SpecialtyTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialtyItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('part1')
            ->add('part2')
            ->add('name')
            ->add('slug')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('specialty', EntityType::class, [
                'class' => Specialty::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('soucre_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('skills', EntityType::class, [
                'class' => SpecialtySkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tables', EntityType::class, [
                'class' => SpecialtyTable::class,
                'choice_label' => 'id',
                'multiple' => true,
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
