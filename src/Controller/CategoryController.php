<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\GameRuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * Display one category
     *
     * @Route("/category/{slug}", name="showCategory")
     * @param $slug
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function show($slug,CategoryRepository $categoryRepository)
    {

        $category = $categoryRepository->findOneBySlug($slug);
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * Display all categories
     *
     * @Route("/category", name="category")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
