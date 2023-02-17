<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashbController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
           
        ]);
    }
}
