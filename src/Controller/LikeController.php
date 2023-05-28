<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Recipes;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    /**
     * Permet de liker une recette 
     */
    #[Route('/like/{id}', name: 'like')]
    public function like(EntityManagerInterface $manager, Recipes $recipe, LikeRepository $likeRepo): Response
    {
        $recipe = $manager->getRepository(Recipes::class)->find($recipe);
        $user = $this->getUser();

        $like = new Like();

        $like->setUser($user);

        $recipe->addLike($like);
        $manager->persist($recipe);
        $manager->flush();

            $this->addFlash(
                "success",
                "Vous avez aimé la recette : ".$recipe->getTitle().""
            );

            return $this->redirectToRoute('recettes_index');
         
    }

    /**
     * Permet de retirer le like sur une recette
     */
    #[Route('/unlike/{id}', name: 'unlike')]
    public function unlike(EntityManagerInterface $manager, Like $like):Response
    {
        
        $manager->remove($like);
        $manager->flush();

        return $this->redirectToRoute('recettes_index');
    }
}