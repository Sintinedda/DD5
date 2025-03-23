<?php

namespace App\Form\Backgrounds;

use App\Entity\Assets\Competence;
use App\Entity\Assets\Language;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Backgrounds\BG;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BGType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('d1', TextareaType::class, [
                'required' => false
            ])
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
            ->add('d3', TextareaType::class, [
                'required' => false
            ])
            ->add('equipment', TextareaType::class, [
                'required' => false
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'abbreviation',
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'number',
                'required' => false
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'abbreviation',
                'multiple' => true,
                'required' => false
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
