<?php

namespace App\Form;

use App\Entity\Recipes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Intitulé de votre recette"))
            ->add('time', IntegerType::class, $this->getConfiguration("Durée", "Durée depréparation de votre recette"))
            ->add('level', TextType::class, $this->getConfiguration("Niveau (facile, moyen, difficile)", "Niveau de la recette"))
            ->add('budget', TextType::class, $this->getConfiguration("Budget (faible, moyen, coûteux)", "Budget de la recette"))
            ->add('portions',IntegerType::class, $this->getConfiguration("Portions", "Nombre de personnes"))
            ->add('image', FileType::class)
            ->add('ingredient', TextType::class, $this->getConfiguration("Ingrédients", "Ingédients de la recette"))
            ->add('steps', TextType::class, $this->getConfiguration("Étapes", "Étapes de la recette"))
            ->add('category', TextType::class, $this->getConfiguration("Catégorie", "Catégorie de la recette"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipes::class,
        ]);
    }
}
