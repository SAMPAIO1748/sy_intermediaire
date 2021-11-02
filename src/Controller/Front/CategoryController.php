<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories/", name="category_list")
     */
    public function categoryList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('front/categories.hmtl.twig', ['categories' => $categories]);
    }

    /**
     * @Route("category/{id}", name="category_show")
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);
        return $this->render('front/category.hmtl.twig', ['category' => $category]);
    }
}
