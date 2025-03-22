<?php

namespace App\Form\Classes;

use App\Entity\Classes\ClasseLevel;
use App\Entity\Classes\ClasseSkill;
use App\Entity\Classes\ClasseSpellcasting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseSkillType extends AbstractType
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
            ->add('spellcasting', EntityType::class, [
                'class' => ClasseSpellcasting::class,
                'choice_label' => 'id',
            ])
            ->add('classeLevels', EntityType::class, [
                'class' => ClasseLevel::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseSkill::class,
        ]);
    }
}
