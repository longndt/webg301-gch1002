<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SClassController extends AbstractController
{
    #[Route('/s/class', name: 'app_s_class')]
    public function index(): Response
    {
        return $this->render('s_class/index.html.twig', [
            'controller_name' => 'SClassController',
        ]);
    }
}
