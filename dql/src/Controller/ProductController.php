<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
     #[Route('/id/asc', name: 'sort_id_ascending')]
     public function sortProductIdAscending (ProductRepository $productRepository) {
         $products = $productRepository->sortByIdAsc();
         return $this->render('product/index.html.twig',
         [
             'products' => $products
         ]);
     }

     #[Route('/id/desc', name: 'sort_id_descending')]
     public function sortProductIdDescending (ProductRepository $productRepository) {
         $products = $productRepository->sortByIdDesc();
         return $this->render('product/index.html.twig',
         [
             'products' => $products
         ]);
     }

     #[Route('/price/asc', name: 'sort_price_ascending')]
     public function sortProductPriceAscending (ProductRepository $productRepository) {
         $products = $productRepository->sortByPriceAsc();
         return $this->render('product/index.html.twig',
         [
             'products' => $products
         ]);
     }

     #[Route('/price/desc', name: 'sort_price_descending')]
     public function sortProductPriceDescending (ProductRepository $productRepository) {
         $products = $productRepository->sortByPriceDesc();
         return $this->render('product/index.html.twig',
         [
             'products' => $products
         ]);
     }

     #[Route('search', name: 'search_by_name')]
     public function searchProductName (ProductRepository $productRepository, Request $request) 
     {
        $keyword = $request->get('keyword');
        $products = $productRepository->searchByName($keyword);
        return $this->render('product/index.html.twig',
        [
            'products' => $products
        ]);
     }

     #[Route('/viewproduct', name: 'view_product')]
     public function viewProduct() {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll(); 
        return $this->json(
            [
                'products' => $products
            ]
        );
     }
}
