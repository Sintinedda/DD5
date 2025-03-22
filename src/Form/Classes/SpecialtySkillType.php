<?php

namespace App\Form\Classes;

use App\Entity\Classes\SpecialtyItem;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Monsters\SB;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialtySkillType extends AbstractType
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
            ->add('specialties', EntityType::class, [
                'class' => SpecialtyItem::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('sB', EntityType::class, [
                'class' => SB::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpecialtySkill::class,
        ]);
    }
}
