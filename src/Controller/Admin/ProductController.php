<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/admin/create/product/", name="admin_create_product")
     */
    public function adminCreateProduct(EntityManagerInterface $entityManagerInterface, Request $request)
    {
        $product = new Product();

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {

            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_list_product');
        }

        return $this->render('admin/product_add.html.twig', ['productForm' => $productForm->createView()]);
    }

    // Après avoir fait la fonction qui crée un nouveau produit, crée la fonction qui modifie un produit
    // et la fonction qui supprime un produit
}
