<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
   //render ra trang homepage 
   //đường dẫn file view: templates/demo/index.html

   #[Route('/', name: 'homepage')]
   public function index() {
     return $this->render("demo/index.html");
   }

   #[Route('/greenwich', name: 'greenwich')]
   public function greenwich() {
     return $this->render("demo/greenwich.html");
   }

   #[Route('/demo1', name: 'demo1')]
   public function demo1() {
     return $this->render("demo1/demo1.html.twig");
   }
}
