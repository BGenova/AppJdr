<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\UserGame;
use App\Form\AddPlayerType;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\UserGameRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * Display all game
     *
     * @Route("/games", name="games")
     * @param GameRepository $gameRepository
     * @return Response
     */
    public function index(GameRepository $gameRepository)
    {
        $games = $gameRepository->findAll();
        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * Create new game
     *
     * @Route("/games/create", name="create")
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        $game = new Game();
        $game->setCreatedAt(new DateTime());
        $game->setOwner($user);
//        $usergame = new UserGame();
//        $usergame->setUsers($user);
//        $usergame->setGames($game);
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            foreach ($game->getGameSlides() as $gameSlides) {
                $gameSlides->setGame($game);
                $manager->persist($gameSlides);
            }
            foreach ($game->getGameBattleMaps() as $gameBattleMaps) {
                $gameBattleMaps->setGame($game);
                $manager->persist($gameBattleMaps);
            }
            foreach ($game->getGameImages() as $gameImages) {
                $gameImages->setGame($game);
                $manager->persist($gameImages);
            }
//            $manager->persist($usergame);
            $manager->persist($game);
            $manager->flush();

            $this->addFlash('success', "<i class=\"fas fa-check\"></i> La partie <strong>{$game->getTitle()}</strong> à bien été crée");
            return $this->redirectToRoute('game', [
                'id' => $game->getId(),
                'slug' => $game->getSlug()
            ]);
        }
        return $this->render('game/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Display game page
     *
     * @Route("/games/{id}", name="game")
     * @param $id
     * @param GameRepository $gameRepository
     * @param UserGameRepository $userGameRepository
     * @param Request $request
     * @return Response
     */
    public function show($id, GameRepository $gameRepository,UserGameRepository $userGameRepository,Request $request)
    {
        $game = $gameRepository->findOneById($id);
        $usergame = $userGameRepository->findBy(array('games' => $id));
        $newusergame = new UserGame();
        $newusergame->setGames($game);


        $form = $this->createForm(AddPlayerType::class, $newusergame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newusergame);
            $manager->flush();

            $this->addFlash('success', "<i class=\"fas fa-check\"></i> La partie <strong>{$game->getTitle()}</strong> à bien été crée");
            return $this->redirectToRoute('game', [
                'id' => $game->getId(),
            ]);
        }
        return $this->render('game/show.html.twig', [
            'game' => $game,
            'usergames' => $usergame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Display table page
     *
     * @Route("/games/table/{id}", name="table")
     * @param $id
     * @param GameRepository $gameRepository
     * @param UserGameRepository $userGameRepository
     * @return Response
     */
    public function showtable($id, GameRepository $gameRepository,UserGameRepository $userGameRepository)
    {
        $game = $gameRepository->findOneById($id);
        $usergame = $userGameRepository->findBy(array('games' => $id));



        return $this->render('game/table1.html.twig', [
            'game' => $game,
            'usergames' => $usergame
        ]);
    }
}
