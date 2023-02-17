<?php

namespace App\Controller;

use App\Entity\Comments;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

     /**
     * Permet de supprimer un commentaire
     */
    #[Route('/comment/{id}/delete', name:"delete_comment")]
    public function deleteRecipe(Comments $comment, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "Le commentaire <strong>{$comment->getId()}</strong> a été supprimée"
        );


        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('recettes_index');
    }
}
