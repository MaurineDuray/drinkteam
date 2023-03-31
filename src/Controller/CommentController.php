<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\Comments;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/comment/{id}', name:"edit_comment")]
    public function editComment(Comments $comment, Request $request, EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire a bien été modifié !"
            );

            $recette = $comment->getIdRecipe()->getSlug();
    
            return $this->redirectToRoute('show_recipe',[
                'slug'=>$recette
            ]);
        }
        return $this->render("comment/edit.html.twig", [
            'myform' => $form->createView(),
            'recipe' => $comment->getIdRecipe()
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
            "Le commentaire a été supprimé"
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
            "Le commentaire a été supprimé"
        );

        

        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('dashboard_comments');
    }


}
