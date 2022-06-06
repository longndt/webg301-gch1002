<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Form\SaleType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SaleController extends Controller
{
    /**
     * Lists all sale entities.
     *
     * @Route("/sale", methods={"GET", "POST"},name="sale_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sales = $em->getRepository(Sale::class)->findAll();

        return $this->render('sale/index.html.twig', array(
            'sales' => $sales,
        ));
    }
    /**
     * Creates a new sale entity.
     *
     * @Route("/sale/new",methods={"GET","POST"}, name="sale_new")
     */
    public function newAction(Request $request)
    {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sale);
            $em->flush();

            return $this->redirectToRoute('sale_index');
        }

        return $this->render('sale/new.html.twig', array(
            'sale' => $sale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sale entity.
     *
     * @Route("/sale/{id}",methods={"GET"} ,name="sale_show")
     */
    public function showAction(Sale $sale)
    {
        $deleteForm = $this->createDeleteForm($sale);

        return $this->render('sale/show.html.twig', array(
            'sale' => $sale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sale entity.
     *
     * @Route("/sale/{id}/edit", methods={"GET","POST"},name="sale_edit")
     */
    public function editAction(Request $request, Sale $sale)
    {
        $deleteForm = $this->createDeleteForm($sale);
        $editForm = $this->createForm(SaleType::class, $sale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sale_index');
        }

        return $this->render('sale/edit.html.twig', array(
            'sale' => $sale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sale entity.
     *
     * @Route("/sale/{id}/delete",name="sale_delete")
     */
    public function deleteAction($id)
    {
        $sale = $this->getDoctrine()->getRepository(Sale::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($sale);
        $em->flush();

        return $this->redirectToRoute('sale_index');
    }

    /**
     * Creates a form to delete a sale entity.
     *
     * @param Sale $sale The sale entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Sale $sale): Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sale_delete', array('id' => $sale->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
