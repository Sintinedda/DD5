<?php

namespace App\Form\Classes;

use App\Entity\Assets\Competence;
use App\Entity\Classes\Classe;
use App\Entity\Items\Item;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSubcategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('d', TextareaType::class)
            ->add('dv', IntegerType::class)
            ->add('save', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'FOR' => 'Force',
                    'DEX' => 'Dextérité',
                    'CON' => 'Constitution',
                    'INT' => 'Intelligence',
                    'SAG' => 'Sagesse',
                    'CHA' => 'Charisme',
                ]
            ])
            ->add('equipment1', TextareaType::class)
            ->add('equipment2', TextareaType::class, [
                'required' => false
            ])
            ->add('equipment3', TextareaType::class, [
                'required' => false
            ])
            ->add('equipment4', TextareaType::class, [
                'required' => false
            ])
            ->add('armor1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false
            ])
            ->add('weapon1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false
            ])
            ->add('tool1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false
            ])
            ->add('tool2', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'slug',
                'required' => false
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ->add('armor2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false
            ])
            ->add('weapon2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false
            ])
        ;

        $builder->get('save')
                ->addModelTransformer(new CallbackTransformer(
                    fn ($saveASArray) => count($saveASArray) ? $saveASArray[0]: null,
                    fn ($saveAsString) => [$saveAsString]
                ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
