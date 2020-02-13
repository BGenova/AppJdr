<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\GameRuleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user_show")
     * @IsGranted("ROLE_USER")
     * @param User $user
     * @return Response
     */
    public function index(User $user)
    {

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
