<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipeType;
use App\Repository\RecipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RecipesController extends AbstractController
{
    /**
     * Affiche les recettes du site
     *
     * @param RecipesRepository $repo
     * @return Response
     */
    #[Route('/recettes', name: 'recettes_index')]
    public function index(RecipesRepository $repo): Response
    {
        $recipes = $repo->findAll();

        return $this->render('recipes/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
    

    /**
     * Permet d'afficher le formulaire de création de l'ajout d'une recette
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recettes/new', name: "new_recipe")]
    #[IsGranted("ROLE_USER")]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $recipe = new Recipes();

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**Gestion de l'image de couverture */
            $file = $form['image']->getData();
            if (!empty($file)) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII;[^A-Za-z0-9_]remove;Lower()', $originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . "." . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                $recipe->setImage($newFilename);
            }

            $manager->persist($recipe);
            $manager->flush();

            /**
             * Message flash pour alerter l'utilisateur de l'état de la tâche
             */
            $this->addFlash(
                'success',
                "L'annonce <strong>{$recipe->getTitle()} - {$recipe->getCategory()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('voitures_show', [
                'slug' => $recipe->getSlug()
            ]);
        }

        return $this->render("recipes/new.html.twig", [
            'myform' => $form->createView()
        ]);
    }


    /**
     * Permet d'afficher une recette en particulier
     */
    #[Route('/recettes/{slug}', name:'show_recipe')]
    public function showRecipe(string $slug, Recipes $recipe):Response
    {
        
        return $this->render('recipes/showRecipe.html.twig',[
            'recipe'=> $recipe
        ]);
    }

}
