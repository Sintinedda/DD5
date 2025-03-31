<?php

namespace App\Form\Items;

use App\Entity\Assets\Damage;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Items\Item;
use App\Entity\Items\ItemProperty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('quantity', IntegerType::class, [
                'required' => false
            ])
            ->add('rarity', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Commun' => 'Commun',
                    'Peu commun' => 'Peu commun',
                    'Rare' => 'Rare',
                    'Très rare' => 'Très rare',
                    'Légendaire' => 'Légendaire',
                    'Artefact' => 'Artefact',
                    'Unique' => 'Unique',
                ]
            ])
            ->add('type', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Armure' => 'Armure',
                    'Potion' => 'Potion',
                    'Anneau' => 'Anneau',
                    'Sceptre' => 'Sceptre',
                    'Parchemin' => 'Parchemin',
                    'Bâton' => 'Bâton',
                    'Baguette' => 'Baguette',
                    'Arme' => 'Arme',
                    'Objet merveilleux' => 'Objet merveilleux',
                ]
            ])
            ->add('cost', IntegerType::class, [
                'required' => false
            ])
            ->add('weight', NumberType::class, [
                'required' => false
            ])
            ->add('ca', IntegerType::class, [
                'required' => false
            ])
            ->add('ca_dex')
            ->add('ca_max')
            ->add('ca_str', IntegerType::class, [
                'required' => false
            ])
            ->add('ca_stealth')
            ->add('ca_don', TextType::class, [
                'required' => false
            ])
            ->add('ca_doff', TextType::class, [
                'required' => false
            ])
            ->add('dice', TextType::class, [
                'required' => false
            ])
            ->add('link')
            ->add('damage', TextType::class, [
                'required' => false
            ])
            ->add('d1', TextareaType::class, [
                'required' => false
            ])
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
            ->add('d3', TextareaType::class, [
                'required' => false
            ])
            ->add('d4', TextareaType::class, [
                'required' => false
            ])
            ->add('d5', TextareaType::class, [
                'required' => false
            ])
            ->add('damage2', EntityType::class, [
                'class' => Damage::class,
                'choice_label' => 'abbreviation',
                'required' => false
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'choice_label' => 'abbreviation',
                'required' => false
            ])
            ->add('source_part', EntityType::class, [
                'class' => SourcePart::class,
                'choice_label' => 'number',
                'required' => false
            ])
            ->add('properties', EntityType::class, [
                'class' => ItemProperty::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
