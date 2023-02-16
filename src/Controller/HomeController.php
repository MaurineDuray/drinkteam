<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\RecipesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(RecipesRepository $recipeRepo,UserRepository $userRepo): Response
    {
        return $this->render('index.html.twig', [
            'recipes' => $recipeRepo->findByLast(3)
        ]);
    }
}
