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
     return $this->render("demo/index.html.twig");
   }

   #[Route('/greenwich', name: 'greenwich')]
   public function greenwich() {
     return $this->render("demo/greenwich.html");
   }

   #[Route('/demo1', name: 'demo1')]
   public function demo1() {
     //  tạo và gửi dữ liệu sang front-end
     $university = "University of Greenwich (Vietnam)";
     $address = "2 Pham Van Bach - Cau Giay - Ha Noi";
     $major = array("Information Technology",
      "Business", "Graphic Design");
     return $this->render("demo/demo1.html.twig",
          [
              'uni' => $university,
              'add' => $address,
              'major' => $major
          ]
    );
   }

   #[Route('/demo2', name: 'demo2')]
   public function demo2() {
    $name = "iPhone 13 Pro Max";
    $color = "Green";
    $price = 1300.50;
    $quantity = 100;
    $in_stock = "True";
    $image = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRvhKu0hQzqpJKzMAi3oG8I6ydAvwWuq1OPaW7QdkxZQhh0EDe33ywm-2oQSm0eCg1h9w&usqp=CAU"; 
    return $this->render("demo/demo2.html.twig",
      [
        'name' => $name,
        'color' => $color,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image,
        'in_stock' => $in_stock
      ]);
   }
}
