<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\UserGame;
use App\Form\AddPlayerType;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\UserGameRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/edit/game/{id}/{slug}", name="edit")
     * @param Game $game
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function edit(Game $game, Request $request)
    {
        // Create an ArrayCollection of the current objects in the Game database
        $originalSlides = new ArrayCollection();
        foreach ($game->getGameSlides() as $gameSlides) {
            $originalSlides->add($gameSlides);
        }
        $originalMap = new ArrayCollection();
        foreach ($game->getGameBattleMaps() as $gameBattleMaps) {
            $originalMap->add($gameBattleMaps);
        }
        $originalImages = new ArrayCollection();
        foreach ($game->getGameSlides() as $gameImages) {
            $originalImages->add($gameImages);
        }

        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game->setUpdatedAt(new DateTime());
            $manager = $this->getDoctrine()->getManager();

            foreach ($originalSlides as $gameSlides) {
                if (false === $game->getGameSlides()->contains($gameSlides)) {
                    $gameSlides->getGame()->removeGameSlide($gameSlides);
                    $manager->persist($gameSlides);
                    $manager->remove($gameSlides);
                }
            }
            foreach ($game->getGameSlides() as $gameSlides) {
                $gameSlides->setGame($game);
                $manager->persist($gameSlides);
            }

            foreach ($originalMap as $gameBattleMaps) {
                if (false === $game->getGameBattleMaps()->contains($gameBattleMaps)) {
                    $gameBattleMaps->getGame()->removeGameBattleMap($gameBattleMaps);
                    $manager->persist($gameBattleMaps);
                    $manager->remove($gameBattleMaps);
                }
            }
            foreach ($game->getGameBattleMaps() as $gameBattleMaps) {
                $gameBattleMaps->setGame($game);
                $manager->persist($gameBattleMaps);
            }

            foreach ($originalImages as $gameImages) {
                if (false === $game->getGameImages()->contains($gameImages)) {
                    $gameImages->getGame()->removeGameImage($gameImages);
                    $manager->persist($gameImages);
                    $manager->remove($gameImages);
                }
            }
            foreach ($game->getGameImages() as $gameImages) {
                $gameImages->setGame($game);
                $manager->persist($gameImages);
            }
            $manager->persist($game);
            $manager->flush();

            $this->addFlash('success', "<i class=\"fas fa-check\"></i> La partie <strong>{$game->getTitle()}</strong> à bien été modifier");
            return $this->redirectToRoute('game', [
                'id' => $game->getId(),
                'slug' => $game->getSlug()
            ]);
        }
        return $this->render('game/edit.html.twig', [
            'form' => $form->createView(),
            'id' => $game->getId(),
            'slug' => $game->getSlug(),
        ]);
    }


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
     * @Route("/game/{id}/{slug}", name="game")
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
                'slug' => $game->getSlug(),
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
