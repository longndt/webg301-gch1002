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

    #[Route('/demo', name: 'demo')]
    public function demo() {
        $country = "Vietnam";
        $year = 2022;
        $numbers = array(10,20,30,40,50);
        return $this->render('demo/demo.html.twig',
        [
            'country' => $country,
            'year' => $year,
            'numbers' => $numbers
        ]);
    }
}
