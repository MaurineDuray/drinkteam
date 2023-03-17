<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\RecipesRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashbController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
           
        ]);
    }

    #[Route('/dashboard/recipes', name:'dashboard_recipes')]
    public function dash_recipes(RecipesRepository $repo ):Response
    {
        $recettes = $repo->findAll();
        return $this->render('dashboard/recipes.html.twig',[
            'recettes'=>$recettes
        ]);
    }

    #[Route('/dashboard/users', name:'dashboard_users')]
    public function dash_users(UserRepository $repo ):Response
    {
        $users = $repo->findAll();
        return $this->render('dashboard/users.html.twig',[
            'users'=>$users
        ]);
    }

    #[Route('/dashboard/comments', name:'dashboard_comments')]
    public function dash_comments(CommentsRepository $repo ):Response
    {
        $comments = $repo->findAll();
        return $this->render('dashboard/comments.html.twig',[
            'comments'=>$comments
        ]);
    }
}
