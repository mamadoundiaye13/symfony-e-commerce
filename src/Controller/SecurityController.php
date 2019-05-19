<?php

// src/Controller/SecurityController.php
namespace App\Controller;

use App\Entity\Articles;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{


    /**
     * @Route("/inscription", name="app_registration")
     * */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $hashPassword = $encoder->encodePassword($user, $user->getPassword());
            $hashConfirmPassword = $encoder->encodePassword($user, $user->getConfirmPassword());

            $user->setPassword($hashPassword);
            $user->setConfirmPassword($hashConfirmPassword);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/login", name="app_login")
     */
    public function login(ArticlesRepository $articlesRepository)
    {

        $articles = $articlesRepository->findAll();

        return $this->render('security/login.html.twig', [
            'articles' => $articles,
        ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     *
    **/


    public function logout(){

    }
}
