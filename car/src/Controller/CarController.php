<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use Symfony\Component\Form\Form;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CarController extends Controller
{
  /**
   * Lists all car entities.
   *
   * @Route("/car", methods={"GET", "POST"},name="car_index")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $cars = $em->getRepository(Car::class)->findAll();

    return $this->render('car/index.html.twig', array(
      'cars' => $cars,
    ));

  }
  /**
   * Creates a new car entity.
   *
   * @Route("/car/new",methods={"GET","POST"}, name="car_new")
   */
  public function newAction(Request $request)
  {
    $car = new Car();
    $form = $this->createForm(CarType::class, $car);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($car);
      $em->flush();

      return $this->redirectToRoute('car_index');
    }

    return $this->render('car/new.html.twig', array(
      'car' => $car,
      'form' => $form->createView(),
    ));
  }

  /**
   * Finds and displays a car entity.
   *
   * @Route("/car/{id}",methods={"GET"} ,name="car_show")
   */
  public function showAction(Car $car)
  {
    $deleteForm = $this->createDeleteForm($car);

    return $this->render('car/show.html.twig', array(
      'car' => $car,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing car entity.
   *
   * @Route("/car/{id}/edit", methods={"GET","POST"},name="car_edit")
   */
  public function editAction(Request $request, Car $car)
  {
    $deleteForm = $this->createDeleteForm($car);
    $editForm = $this->createForm(CarType::class, $car);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('car_index');
    }

    return $this->render('car/edit.html.twig', array(
      'car' => $car,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a car entity.
   *
   * @Route("/car/{id}/delete",name="car_delete")
   */
  public function deleteAction($id)
  {
    $car = $this->getDoctrine()->getRepository(Car::class)->find($id);
    $em = $this->getDoctrine()->getManager();
    $em->remove($car);
    $em->flush();

    return $this->redirectToRoute('car_index');
  }

  /**
   * Creates a form to delete a car entity.
   *
   * @param Car $car The car entity
   *
   * @return Form The form
   */
  private function createDeleteForm(Car $car): Form
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }

  /**
   * @Route("/cars/{make}", name="car_from_make")
   */
  public function carFromMake ($make, CarRepository $carRepository) {
      $result = $carRepository->carFromMake($make);
      return $this->render('car/index.html.twig', 
      array(
        'cars' => $result
      ));
  }
}
