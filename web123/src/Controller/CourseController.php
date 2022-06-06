<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/course')]
class CourseController extends AbstractController
{
    #[Route('/', name: 'view_course_list')]
    public function CourseIndex(CourseRepository $courseRepository)
    {
        $courses = $courseRepository->findAll();
        return $this->render(
            "course/index.html.twig",
        [
            'courses' => $courses
        ]
        );
    }

    #[Route('/{id}', name: 'view_course_by_id')]
    public function CourseDetail(CourseRepository $courseRepository, $id)
    {
        $course = $courseRepository->find($id);
        return $this->render(
            "course/detail.html.twig",
        [
            'course' => $course
        ]
        );
    }

    #[Route('/delete/{$id}', name: 'delete_course')]
    public function CourseDelete(CourseRepository $courseRepository, $id) {
        $course = $courseRepository->find($id);
        if ($course == null) {
            $this->addFlash("Error","Course not found !");        
        } 
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($course);
            $manager->flush();
            $this->addFlash("Success","Delete course succeed  !");
        }
        return $this->redirectToRoute("view_course_list");
    }
}