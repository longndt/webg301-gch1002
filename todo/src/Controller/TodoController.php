<?php

namespace App\Controller;

use App\Repository\TodoRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function todoDetail(TodoRepository $todoRepository, $id) {
        $todo = $todoRepository->find(($id));
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
}
