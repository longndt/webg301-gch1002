<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Repository\MobileRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
   #[Route('/', name: 'mobile')]
   public function viewAllMobile (MobileRepository $mobileRepository) {
        $mobiles = $mobileRepository->findAll();
        return $this->render("mobile/index.html.twig",
        [
            'mobiles' => $mobiles
        ]);
   }

   #[Route('/{id}', name: 'mobile_detail')]
   public function viewMobileById ($id, ManagerRegistry $managerRegistry) {
       $mobile = $managerRegistry->getRepository(Mobile::class)->find($id);
       return $this->render("mobile/detail.html.twig",
        [
            'mobile' => $mobile
        ]);
   }
}
