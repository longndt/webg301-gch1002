<?php

namespace App\Controller;

use App\Entity\Part;
use App\Form\PartType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartController extends Controller
{
  /**
   * Lists all part entities.
   *
   * @Route("/part", methods={"GET", "POST"},name="part_index")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $parts = $em->getRepository(Part::class)->findAll();

    return $this->render('part/index.html.twig', array(
      'parts' => $parts,
    ));
  }
  /**
   * Creates a new part entity.
   *
   * @Route("/part/new",methods={"GET","POST"}, name="part_new")
   */
  public function newAction(Request $request)
  {
    $part = new Part();
    $form = $this->createForm(PartType::class, $part);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($part);
      $em->flush();

      return $this->redirectToRoute('part_index');
    }

    return $this->render('part/new.html.twig', array(
      'part' => $part,
      'form' => $form->createView(),
    ));
  }

  /**
   * Finds and displays a part entity.
   *
   * @Route("/part/{id}",methods={"GET"} ,name="part_show")
   */
  public function showAction(Part $part)
  {
    $deleteForm = $this->createDeleteForm($part);

    return $this->render('part/show.html.twig', array(
      'part' => $part,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing part entity.
   *
   * @Route("/part/{id}/edit", methods={"GET","POST"},name="part_edit")
   */
  public function editAction(Request $request, Part $part)
  {
    $deleteForm = $this->createDeleteForm($part);
    $editForm = $this->createForm(PartType::class, $part);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('part_index');
    }

    return $this->render('part/edit.html.twig', array(
      'part' => $part,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a part entity.
   *
   * @Route("/part/{id}/delete",name="part_delete")
   */
  public function deleteAction($id)
  {
    $part = $this->getDoctrine()->getRepository(Part::class)->find($id);
    $em = $this->getDoctrine()->getManager();
    $em->remove($part);
    $em->flush();

    return $this->redirectToRoute('part_index');
  }

  /**
   * Creates a form to delete a part entity.
   *
   * @param Part $part The part entity
   *
   * @return Form The form
   */
  private function createDeleteForm(Part $part): Form
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('part_delete', array('id' => $part->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }
}
