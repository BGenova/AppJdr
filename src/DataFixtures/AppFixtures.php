<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\UserGame;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        // User create

        $users = [];
        $games = [];

        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $hash = $this->encoder->encodePassword($user,'password');

            $longdescription = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
            $user->setFirstName($faker->firstname)
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setnickName($faker->firstName)
                ->setShortdescription($faker->sentence())
                ->setLongDescription($longdescription)
                ->setHash($hash)
                ->setAvatar("http://placehold.it/150x150")
                ->setCreatedAt(new DateTime());
            $manager->persist($user);
            $manager->flush();
            $users[] = $user;
        }

        for ($i = 1; $i <= 10; $i++) {
            $user = $users[mt_rand(0, count($users) - 1)];;
            $game = new Game();
            $longdescription = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';

            $game->setTitle($faker->sentence())
                ->setCoverImage("http://placehold.it/1000x350")
                ->setShortDescription($faker->paragraph(2))
                ->setLongDescription($longdescription)
                ->setCreatedAt(new DateTime())
                ->setOwner(5);
            $manager->persist($game);
            $manager->flush();
            $games[] = $game;
        }
        for ($i = 1; $i <= 50; $i++) {
            $game = $games[mt_rand(0, count($games) - 1)];
//            $gameid = $game->getId();
            $user = $users[mt_rand(0, count($users) - 1)];
//            $userid = $user->getId();

            $gameuser = new UserGame();
            $gameuser->setGames($game);
            $gameuser->setUsers($user);

            $manager->persist($gameuser);
        }

        $manager->flush();
    }
}