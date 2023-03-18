<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Recipes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like/{slug}', name: 'like')]
    public function like(EntityManagerInterface $manager, Recipes $recipe, string $slug): Response
    {
        $like = new Like();

        $like->setUser($this->getUser())
        ->setRecipe($recipe);

        $manager->persist($like);
        $manager->flush();
           
        return $this->redirectToRoute('recettes_index');
    }

    #[Route('/unlike/{slug}', name: 'unlike')]
    public function unlike(EntityManagerInterface $manager, Like $like):Response
    {
        $manager->remove($like);
        $manager->flush();

        return $this->redirectToRoute('recettes_index');
    }
}
