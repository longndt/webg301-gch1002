<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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

    #[Route('/detail/{id}', name: 'view_course_by_id')]
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

     /**
     * @IsGranted("ROLE_MANAGER")
     */
    #[Route('/delete/{id}', name: 'delete_course')]
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

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/add', name: 'add_course')]
    public function CourseAdd(Request $request) {
        $course = new Course;
        $form = $this->createForm(CourseType::class,$course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash("Success","Add course succeed !");
            return $this->redirectToRoute("view_course_list");
        }
        return $this->render("course/add.html.twig",
        [
            'courseForm' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_course')]
    public function CourseEdit(Request $request, CourseRepository $courseRepository, $id) {
        $course = $courseRepository->find($id);
        if ($course == null) {
            $this->addFlash("Error","Course not found !");
            return $this->redirectToRoute("view_course_list");        
        } else {
            $form = $this->createForm(CourseType::class,$course);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($course);
                $manager->flush();
                $this->addFlash("Success","Edit course succeed !");
                return $this->redirectToRoute("view_course_list");
            }
            return $this->renderForm("course/edit.html.twig",
            [
                'courseForm' => $form
            ]);
        }   
    }

    #[Route('/sortbyname/asc', name: 'sort_course_name_ascending')]
    public function CourseSortAscending(CourseRepository $courseRepository) {
        $courses = $courseRepository->sortByNameAscending();
        return $this->render(
            "course/index.html.twig",
            [
                'courses' => $courses
            ]);
    }

    #[Route('/sortbyname/desc', name: 'sort_course_name_descending')]
    public function CourseSortDescending(CourseRepository $courseRepository) {
        $courses = $courseRepository->sortByNameDescending();
        return $this->render(
            "course/index.html.twig",
            [
                'courses' => $courses
            ]);
    }

    #[Route('/searchbyname', name: 'search_course_name')]
    public function CourseSearchByName (CourseRepository $courseRepository, Request $request) {
        $name = $request->get('keyword');
        $courses = $courseRepository->searchByName($name);
        return $this->render(
            "course/index.html.twig",
            [
                'courses' => $courses
            ]);
    }
}