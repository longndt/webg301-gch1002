<?php

namespace App\Controller;

use App\Entity\Lecturer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lecturer')]
class LecturerController extends AbstractController
{
    #[Route('/ ', name: 'view_lecturer_list')]
    public function LecturerIndex(ManagerRegistry $managerRegistry) {
        $lecturers = $managerRegistry->getRepository(Lecturer::class)->findAll();
        return $this->render("lecturer/index.html.twig",
        [
            'lecturers' => $lecturers
        ]);
    }

    #[Route('/{id}', name: 'view_lecturer_by_id')]
    public function LecturerDetail(ManagerRegistry $managerRegistry, $id) {
        $lecturer = $managerRegistry->getRepository(Lecturer::class)->find($id);
        return $this->render("lecturer/detail.html.twig",
        [
            'lecturer' => $lecturer
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_lecturer')]
    public function LecturerDelete(ManagerRegistry $managerRegistry, $id) {
        $lecturer = $managerRegistry->getRepository(Lecturer::class)->find($id);
        if ($lecturer == null) {
            $this->addFlash("Error","Lecturer not found !");        
        } 
        else if (count($lecturer->getCourses()) >= 1 ) {
            $this->addFlash("Error","Can not delete this lecturer !");
        }
        else {
            $manager = $managerRegistry->getManager();
            $manager->remove($lecturer);
            $manager->flush();
            $this->addFlash("Success","Delete lecturer succeed  !");
        }
        return $this->redirectToRoute("view_lecturer_list");
    }
}
