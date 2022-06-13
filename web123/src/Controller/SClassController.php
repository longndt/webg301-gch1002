<?php

namespace App\Controller;

use App\Entity\SClass;
use App\Form\SClassType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/class')]
class SClassController extends AbstractController
{
    #[Route('/api', name: 'view_class_list_api')]
    public function ClassIndexApi() {
      $classes = $this->getDoctrine()->getRepository(SClass::class)->findAll();
      return $this->json(
          [
            'classes' => $classes
          ]
      );
    }

    #[Route('/', name: 'view_class_list')]
    public function ClassIndex() {
      $classes = $this->getDoctrine()->getRepository(SClass::class)->findAll();
      return $this->render("class/index.html.twig",
      [
          'classes' => $classes
      ]);
    }

    #[Route('/detail/{id}', name: 'view_class_by_id')]
    public function ClassDetail($id) {
        $class = $this->getDoctrine()->getRepository(SClass::class)-> find($id);
        if ($class == null) {
            $this->addFlash("Error","Class not found !");
            return $this->redirectToRoute("view_class_list");
        }
        return $this->render(
            'class/detail.html.twig',
        [
            'class' => $class
        ]);
    }

    #[Route('/delete/{$id}', name: 'delete_class')]
    public function ClassDelete($id) {
        $class = $this->getDoctrine()->getRepository(SClass::class)-> find($id);
        if ($class == null) {
            $this->addFlash("Error","Class not found !");        
        } 
        else if (count($class->getCourses()) >= 1 ) {
            $this->addFlash("Error","Can not delete this class !");
        }
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($class);
            $manager->flush();
            $this->addFlash("Success","Delete class succeed  !");
        }
        return $this->redirectToRoute("view_class_list");
    }

    #[Route('/add', name: 'add_class')]
    public function ClassAdd(Request $request) {
        $class = new SClass;
        $form = $this->createForm(SClassType::class,$class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($class);
            $manager->flush();
            $this->addFlash("Success","Add class succeed !");
            return $this->redirectToRoute("view_class_list");
        }
        return $this->renderForm("class/add.html.twig",
        [
            'classForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_class')]
    public function ClassEdit(Request $request, $id) {
        $class = $this->getDoctrine()->getRepository(SClass::class)->find($id);
        if ($class == null) {
            $this->addFlash("Error","Class not found !");
            return $this->redirectToRoute("view_class_list");        
        } else {
            $form = $this->createForm(SClassType::class,$class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($class);
                $manager->flush();
                $this->addFlash("Success","Edit class succeed !");
                return $this->redirectToRoute("view_class_list");
            }
            return $this->renderForm("class/edit.html.twig",
            [
                'classForm' => $form
            ]);
        }   
    }
} 