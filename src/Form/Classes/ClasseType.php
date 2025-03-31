<?php

namespace App\Form\Classes;

use App\Entity\Assets\Competence;
use App\Entity\Classes\Classe;
use App\Entity\Items\Item;
use App\Entity\Items\ItemSubcategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
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
            ->add('icon', TextType::class)
            ->add('slug', TextType::class)
            ->add('gold', TextType::class)
            ->add('d', TextareaType::class)
            ->add('d2', TextareaType::class, [
                'required' => false
            ])
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
                'required' => false,
                'group_by' => function($item) {
                    return $item->getSubcategory()->getSlug();
                },
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('a')
                        ->join('a.subcategory', 's')
                        ->join('s.category', 'c')
                        ->where('c.slug = :armures')
                        ->setParameter('armures', 'armures');
                }
            ])
            ->add('weapon1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false,
                'group_by' => function($item) {
                    return $item->getSubcategory()->getSlug();
                },
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('w')
                        ->join('w.subcategory', 's')
                        ->join('s.category', 'c')
                        ->where('c.slug = :armes')
                        ->setParameter('armes', 'armes');
                }
            ])
            ->add('tool1', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false,
                'group_by' => function($item) {
                    return $item->getSubcategory()->getSlug();
                },
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('t')
                        ->join('t.subcategory', 's')
                        ->join('s.category', 'c')
                        ->where('c.slug = :outils')
                        ->setParameter('outils', 'outils');
                }
            ])
            ->add('tool2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'slug',
                'required' => false,
                'multiple' => true,
                'group_by' => function($item) {
                    return $item->getCategory()->getSlug();
                },
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('t')
                        ->join('t.category', 'c')
                        ->where('c.slug = :outils')
                        ->setParameter('outils', 'outils');
                }
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('armor2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false,
                'group_by' => function($item) {
                    return $item->getCategory()->getSlug();
                },
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('a')
                        ->join('a.category', 'c')
                        ->where('c.slug = :armures')
                        ->setParameter('armures', 'armures');
                }
            ])
            ->add('weapon2', EntityType::class, [
                'class' => ItemSubcategory::class,
                'choice_label' => 'slug',
                'multiple' => true,
                'required' => false,
                'group_by' => function($item) {
                    return $item->getCategory()->getSlug();
                },
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('w')
                        ->join('w.category', 'c')
                        ->where('c.slug = :armes')
                        ->setParameter('armes', 'armes');
                }
            ])
            ->add('spell5')
            ->add('spell9')
            ->add('spell')
            ->add('cantrip')
            ->add('infusion')
            ->add('rage')
            ->add('martial')
            ->add('sneak')
            ->add('sorcery')
            ->add('slot')
            ->add('invocation')
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
