<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Form\SigninType;

class SigninController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function index(Request $req, \Doctrine\ORM\EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(SigninType::class, $user);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user = $form->getData();

            $plaintextPassword = $user->getPassword();

            $hashedPassword = $passwordHasher->hashPassword
            ($user, $plaintextPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            

            $entityManager->flush();
            $this->addFlash('success', 'User successfully registered!');
        } else if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'An error occurred while registering the user!');
        }

        return $this->render('signin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}