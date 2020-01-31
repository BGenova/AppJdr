<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\GameBookRepository;
use App\Repository\GameRuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameBookController extends AbstractController
{
    /**
     * Display one gamebook
     *
     * @Route("/livre/{slug}", name="showGamerule")
     * @param $slug
     * @param GameBookRepository $gameBookRepository
     * @return Response
     */
    public function show($slug,GameBookRepository $gameBookRepository)
    {
        $gamebook = $gameBookRepository->findOneBySlug($slug);

        return $this->render('gamerule/show.html.twig', [
            'gamebook' => $gamebook,
        ]);
    }

    /**
     * @Route("/livre", name="gamebook")
     * @param GameBookRepository $gameBookRepository
     * @return Response
     */
    public function index(GameBookRepository $gameBookRepository)
    {
        $gamebooks = $gameBookRepository->findAll();
        return $this->render('gamebook/index.html.twig', [
            'gamebooks' => $gamebooks,
        ]);
    }
}
