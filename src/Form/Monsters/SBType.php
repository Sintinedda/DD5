<?php

namespace App\Form\Monsters;

use App\Entity\Assets\CreatureType;
use App\Entity\Assets\Sense;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Monsters\SB;
use App\Entity\Monsters\SBSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_fr')
            ->add('name_eng')
            ->add('slug')
            ->add('category')
            ->add('type2')
            ->add('sizes')
            ->add('size_inf')
            ->add('size_sup')
            ->add('ca')
            ->add('armor')
            ->add('pv')
            ->add('dv')
            ->add('speeds')
            ->add('strenght')
            ->add('dexterity')
            ->add('constitution')
            ->add('intelligence')
            ->add('wisdow')
            ->add('charisma')
            ->add('save')
            ->add('competence')
            ->add('pp')
            ->add('pp2')
            ->add('fp')
            ->add('xp')
            ->add('bm')
            ->add('d')
            ->add('cac_t')
            ->add('cac_r')
            ->add('cac_d')
            ->add('range_t')
            ->add('range_r')
            ->add('range_d')
            ->add('type', EntityType::class, [
                'class' => CreatureType::class,
                'choice_label' => 'id',
            ])
            ->add('sens', EntityType::class, [
                'class' => Sense::class,
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
            ->add('specialty', EntityType::class, [
                'class' => SpecialtySkill::class,
                'choice_label' => 'id',
            ])
            ->add('skills', EntityType::class, [
                'class' => SBSkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SB::class,
        ]);
    }
}
