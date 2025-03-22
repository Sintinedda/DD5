<?php

namespace App\Form\Backgrounds;

use App\Entity\Assets\Competence;
use App\Entity\Assets\Language;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Backgrounds\BG;
use App\Entity\Backgrounds\BGCarac;
use App\Entity\Backgrounds\BGSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BGType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('equipment')
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'id',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'id',
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('Language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('skills', EntityType::class, [
                'class' => BGSkill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('carac', EntityType::class, [
                'class' => BGCarac::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BG::class,
        ]);
    }
}
