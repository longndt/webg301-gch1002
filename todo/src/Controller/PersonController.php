<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/person")]
class PersonController extends AbstractController
{
   #[Route("/", name: "person_index")]  
   public function personIndex() {
       $persons = $this->getDoctrine()->getRepository(Person::class)->findAll();
       if ($persons == null) {
           $this->addFlash("Error", "There is no person record yet");
       }
       return $this->render(
           "person/index.html.twig",
            [
               'persons' => $persons
            ]
       );
   }

   #[Route("/detail/{id}", name: "person_detail")]
   public function personDetail($id, ManagerRegistry $managerRegistry) {
      $person = $managerRegistry->getRepository(Person::class)->find($id);
      if ($person == null) {
         $this->addFlash("Error", "Person not found");
         return $this->redirectToRoute("person_index");
      } 
      return $this->render("person/detail.html.twig",
      [
         'person' => $person
      ]);
   }

   #[Route("/delete/{id}", name: "person_delete")]
   public function personDelete ($id, PersonRepository $personRepository) {
      $person = $personRepository->find($id);
      //TH1: xóa person không tồn tại => báo lỗi
      if ($person == null) {
         $this->addFlash("Error", "Person not found !");
      }
      //TH2: xóa person đang còn liên kết với todo => báo lỗi
      else if (count($person->getTodos()) >= 1) {
         $this->addFlash("Error", "Can not delete this person !");
      }
      //TH3: person có tồn tại và không còn liên kết với todo => xóa khỏi DB và trả về thông báo
      else {
         $manager = $this->getDoctrine()->getManager();
         $manager->remove($person);
         $manager->flush();
         $this->addFlash("Success", "Delete person succeed !");
      }
      return $this->redirectToRoute("person_index");
   }

   #[Route("/add", name: "person_add")]
   public function addPerson(Request $request) {
      $person = new Person;
      $form = $this->createForm(PersonType::class, $person);
      $form->handleRequest($request);
      $title = "Add new person";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($person);
         $manager->flush();
         $this->addFlash("Success","Add person succeed !");
         return $this->redirectToRoute("person_index");
      }
      return $this->renderForm("person/save.html.twig",
      [
         'personForm' => $form,
         'title' => $title
      ]);
   }

   #[Route("/edit/{id}", name: "person_edit")]
   public function editPerson(Request $request, $id) {
      $person = $this->getDoctrine()->getRepository(Person::class)->find($id);
      $form = $this->createForm(PersonType::class, $person);
      $form->handleRequest($request);
      $title = "Edit person";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($person);
         $manager->flush();
         $this->addFlash("Success","Edit person succeed !");
         return $this->redirectToRoute("person_index");
      }
      return $this->renderForm("person/save.html.twig",
      [
         'personForm' => $form,
         'title' => $title
      ]);
   }
}
