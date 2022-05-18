<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MobileController extends AbstractController
{
   #[Route('/', name: 'mobile_list')]
   public function viewAllMobile (MobileRepository $mobileRepository) {
        $mobiles = $mobileRepository->findAll();
        return $this->render("mobile/index.html.twig",
        [
            'mobiles' => $mobiles
        ]);
   }
}
