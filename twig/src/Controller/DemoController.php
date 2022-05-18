<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    #[Route('/seagame', name: 'seagame')]
    public function seagame() 
    {
        return $this->render('demo/seagame.html.twig');
    }
}
