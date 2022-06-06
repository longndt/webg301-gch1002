<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Form\SupplierType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SupplierController extends Controller
{
    /**
     * Lists all supplier entities.
     *
     * @Route("/supplier", methods={"GET", "POST"},name="supplier_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suppliers = $em->getRepository(Supplier::class)->findAll();

        return $this->render('supplier/index.html.twig', array(
            'suppliers' => $suppliers,
        ));
    }
    /**
     * Creates a new supplier entity.
     *
     * @Route("/supplier/new",methods={"GET","POST"}, name="supplier_new")
     */
    public function newAction(Request $request)
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($supplier);
            $em->flush();

            return $this->redirectToRoute('supplier_index');
        }

        return $this->render('supplier/new.html.twig', array(
            'supplier' => $supplier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a supplier entity.
     *
     * @Route("/supplier/{id}",methods={"GET"} ,name="supplier_show")
     */
    public function showAction(Supplier $supplier)
    {
        $deleteForm = $this->createDeleteForm($supplier);

        return $this->render('supplier/show.html.twig', array(
            'supplier' => $supplier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing supplier entity.
     *
     * @Route("/supplier/{id}/edit", methods={"GET","POST"},name="supplier_edit")
     */
    public function editAction(Request $request, Supplier $supplier)
    {
        $deleteForm = $this->createDeleteForm($supplier);
        $editForm = $this->createForm(SupplierType::class, $supplier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('supplier_index');
        }

        return $this->render('supplier/edit.html.twig', array(
            'supplier' => $supplier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a supplier entity.
     *
     * @Route("/supplier/{id}/delete",name="supplier_delete")
     */
    public function deleteAction($id)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($supplier);
        $em->flush();

        return $this->redirectToRoute('supplier_index');
    }

    /**
     * Creates a form to delete a supplier entity.
     *
     * @param Supplier $supplier The supplier entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Supplier $supplier): Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('supplier_delete', array('id' => $supplier->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
