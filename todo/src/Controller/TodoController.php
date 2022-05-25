<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/', name: 'todo_index')]
    public function todoIndex(TodoRepository $todoRepository) {
        $todos = $todoRepository->findAll();
        return $this->render("todo/index.html.twig",
        [
            'todos' => $todos
        ]);
    } 

    #[Route('/detail/{id}', name: 'todo_detail')]
    public function todoDetail(ManagerRegistry $managerRegistry, $id) {
        $todo = $managerRegistry->getRepository(Todo::class)->find(($id));
        if ($todo == null) {
            //gửi flash message về view
            $this->addFlash("Error","Todo not found !");
            return $this->redirectToRoute("todo_index");
        } else {
            return $this->render("todo/detail.html.twig",
            [
                'todo' => $todo
            ]);
        }
    }

    #[Route("/delete/{id}", name: 'todo_delete')]
    public function todoDelete(TodoRepository $todoRepository, $id) {
        $todo = $todoRepository->find($id);
        if ($todo == null) {
            $this->addFlash("Error", "Can not delete this Todo !");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($todo);
            $manager->flush();
            $this->addFlash("Success", "Delete todo succeed !");
        }
        return $this->redirectToRoute("todo_index");
    }

    #[Route("/add", name: 'todo_add' )]
    public function todoAdd(Request $request, ManagerRegistry $managerRegistry) {
        $todo = new Todo;
        $form = $this->createForm(TodoType::class,$todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($todo);
            $manager->flush();
            $this->addFlash("Success", "Add new Todo successfully !");
            return $this->redirectToRoute("todo_index");
        }
        return $this->renderForm("todo/add.html.twig",
        [
            'todoForm' => $form
        ]);
    }

    #[Route("/edit/{id}", name: 'todo_edit')]
    public function todoEdit(Request $request, $id) {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        if ($todo == null) {
            $this->addFlash("Error","Can not update non-existed Todo !");   
            return $this->redirectToRoute("todo_index");
        } else {
            $form = $this->createForm(TodoType::class, $todo);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($todo);
                $manager->flush();
                $this->addFlash("Success", "Update Todo successfully !");
                return $this->redirectToRoute("todo_index");
            }
        }
        return $this->renderForm("todo/edit.html.twig",
        [
            'todoForm' => $form
        ]);
    }
}
