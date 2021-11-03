<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @Route("/admin/products/", name="admin_list_product")
     */
    public function adminListProduct(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('admin/products.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin_product_show")
     */
    public function adminProductShow($id, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);

        return $this->render('admin/product.html.twig', ['product' => $product]);
    }

    // fonction qui créer un nouveau produit
}
