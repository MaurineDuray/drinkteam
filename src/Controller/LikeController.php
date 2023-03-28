<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Recipes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/{slug}', name: 'like')]
    public function like(EntityManagerInterface $manager, Recipes $recipe, string $slug, Request $request): Response
    {
        $like = new Like();

        $like->setUser($this->getUser())
        ->setRecipe($recipe);

        $manager->persist($like);
        $manager->flush();
           
        return $this->redirect($request->getUri());
    }

    #[Route('/unlike/{slug}', name: 'unlike')]
    public function unlike(EntityManagerInterface $manager, Like $like, Request $request):Response
    {
        $manager->remove($like);
        $manager->flush();

        return $this->redirect($request->getUri());
    }
}
