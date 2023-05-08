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
    #[Route('/like/{id}', name: 'like')]
    public function like(EntityManagerInterface $manager, Recipes $recipe): Response
    {
        $like = new Like();

        $like->setUser($this->getUser())
        ->setRecipe($recipe);

        $manager->persist($like);
        $manager->flush();
           
        return $this->redirectToRoute('recettes_index');
    }

    #[Route('/unlike/{id}', name: 'unlike')]
    public function unlike(EntityManagerInterface $manager, Like $like):Response
    {
        
        $manager->remove($like);
        $manager->flush();

        return $this->redirectToRoute('recettes_index');
    }
}
