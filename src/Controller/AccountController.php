<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use App\Repository\CategoryRepository;
use App\Repository\GameRuleRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Login
     *
     * @Route("/login", name="account_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Logout
     *
     * @Route("/logout", name="account_logout")
     * @return Response
     */
    public function logout()
    {
        return $this->render('account/login.html.twig');
    }

    /**
     * Registration
     *
     * @Route("/registration", name="account_registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // Create User
        $user = new User();
        $user->setCreatedAt(new DateTime());

        // Form
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte à bien été crée ! Vous pouvez maintenant vous connecter"
            );

            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Display update profile
     *
     * @Route("/account/profile", name="account_profile")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function profile(Request $request)
    {
        // Update User
        $user = $this->getUser();
        $user->setUpdatedAt(new DateTime());

        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        // Check response and update user.
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre mot de passe à bien été modifier !"
            );
        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Change password
     *
     * @Route("/account/password-update", name="account_password")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getPassword())){

                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez taper n'est pas le mot de passe actuel"))
                    ->get('confirmPassword')->addError(new FormError("Les mot de passe ne sont pas identique"));

            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre compte à bien été modifier !"
                );
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
