<?php

namespace App\Controller;

use App\Service\StatsService;
use App\Repository\UserRepository;
use App\Repository\RecipesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(RecipesRepository $recipeRepo,StatsService $stats): Response
    {
        $users = $stats->getUsersCount();
        // getSingleScalarResult() Permet de récupérer une valeur et pas un array 
        $recipes=$stats->getRecipesCount();
       
        $comments=$stats->getCommentsCount();

        $bestRecipes = $stats->getRecipesStats('DESC');

      

        return $this->render('index.html.twig', [
            'recipes' => $recipeRepo->findByLast(3),
            'stats' => [
                'users'=>$users,
                'recipes'=>$recipes,
                'comments'=>$comments
            ],
            'bestRecipes'=>$bestRecipes
            
        ]);
    }
}
