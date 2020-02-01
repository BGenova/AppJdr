<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\GameBook;
use App\Entity\GameNote;
use App\Entity\GameRule;
use App\Entity\GameSlide;
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

        for($i = 1; $i <= 100; $i++){
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

        //  Category GameRule Game create
        for ($c = 1; $c <= 4; $c++) {
            $category = new Category();

            $longdescription = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
            $category->setTitle($faker->sentence())
                ->setShortDescription($category->getTitle() . " " . $faker->sentence())
                ->setLongDescription($longdescription)
                ->setCoverImage("http://placehold.it/1000x350");

            for ($r = 1; $r <= 3; $r++) {
                $gamerule = new GameBook();

                $longdescription = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
                $gamerule->setTitle($faker->sentence(3))
                    ->setShortDescription($faker->sentence())
                    ->setLongDescription($longdescription)
                    ->setCoverImage("http://placehold.it/1000x350")
                    ->setIcon("<span class=\"text-danger\"><i class=\"fas fa-dice-d20\"></i></span>")
                    ->setCategory($category);

                for ($i = 1; $i <= 4; $i++) {
                    $user = $users[mt_rand(0, count($users) - 1)];
                    $server = rand(1,2);
                    $userid = $user->getId();
                    $game = new Game();
                    $longdescription = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';

                    $game->setTitle($faker->sentence())
                        ->setCoverImage("http://placehold.it/1000x350")
                        ->setShortDescription($faker->paragraph(2))
                        ->setLongDescription($longdescription)
                        ->setCreatedAt(new DateTime())
                        ->setNextGameAt(new DateTime())
                        ->setGameBook($gamerule)
                        ->setOwner($user);
                    $manager->persist($game);
                    $manager->flush();


                        $gameuser = new UserGame();
                        $gameuser->setUsers($user);

                    for ($i = 1; $i <= 4; $i++) {
                        $gameuser = new UserGame();
                        $user = $users[mt_rand(0, count($users) - 1)];
                        $gameuser->setUsers($user);
                        $gameuser->setGames($game);
                        $manager->persist($gameuser);
                    }
                    $games[] = $game;

                    for ($j = 1; $j <= 4; $j++) {
                        $slide = new GameSlide();

                        $slide->setUrl("http://placehold.it/1000x350")
                            ->setCaption($faker->sentence())
                            ->setGame($game);
                        $manager->persist($slide);
                    }
                    for ($n = 1; $n <= 4; $n++) {
                        $note = new GameNote();

                        $note->setTitle($faker->sentence())
                            ->setContent($faker->sentence())
                            ->setGame($game);
                        $manager->persist($note);
                    }
                }
                $manager->persist($gamerule);
            }
            $manager->persist($category);
            $manager->flush();
        }
        $manager->flush();
    }
}