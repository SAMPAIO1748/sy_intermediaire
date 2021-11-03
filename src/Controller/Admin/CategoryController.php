<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/admin/categories/", name="admin_list_category")
     */
    public function adminListCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/categories.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/admin/category/{id}", name="admin_category_show")
     */
    public function adminCategoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render('admin/category.html.twig', ['category' => $category]);
    }

    /**
     * @Route("/admin/create/category/", name="admin_create_category")
     */
    public function adminCreateCategory(EntityManagerInterface $entityManagerInterface, Request $request)
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();
            $this->addFlash('notice', 'Votre catégorie a été créée.');

            return $this->redirectToRoute('admin_list_category');
        }

        return $this->render('admin/category_add.html.twig', ['categoryForm' => $categoryForm->createView()]);
    }

    /**
     * @Route("/admin/update/category/{id}", name="admin_update_category")
     */
    public function adminUpdateCategory(
        $id,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        CategoryRepository $categoryRepository
    ) {

        $category = $categoryRepository->find($id);

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();
            $this->addFlash('notice', 'Le produit a été modifié.');

            return $this->redirectToRoute('admin_list_category');
        }

        return $this->render('admin/category_add.html.twig', ['categoryForm' => $categoryForm->createView()]);
    }

    /**
     * @Route("/admin/delete/category/{id}", name="admin_delete_category")
     */
    public function adminDeleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManagerInterface)
    {
        $category = $categoryRepository->find($id);

        $entityManagerInterface->remove($category);
        $entityManagerInterface->flush();
        $this->addFlash('notice', 'Votre produit a été supprimé');

        return $this->redirectToRoute('admin_list_category');
    }

    // Dans le dossier Admin, créer un CategoryController avec toutes les fonctions pour le CRUD.

}
