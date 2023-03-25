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
    public function deleteComment(Comments $comment, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "Le commentaire <strong>{$comment->getId()}</strong> a été supprimée"
        );
        $recette = $comment->getIdRecipe()->getSlug();

        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('show_recipe',[
            'slug'=>$recette
        ]);
    }
     /**
     * Permet de supprimer un commentaire à partir de l'admin
     */
    #[Route('admin/comment/{id}/delete', name:"admin_delete_comment")]
    public function deleteCommentAdmin(Comments $comment, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "Le commentaire <strong>{$comment->getId()}</strong> a été supprimée"
        );

        

        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('dashboard_comments');
    }


}
