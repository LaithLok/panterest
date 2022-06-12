<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function show(): Response
    {
        return $this->render('account/show.html.twig');
    }

     #[Route('/account/edit', name: 'app_account_edit',methods:'GET|POST')]


        public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();


        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Account updated successfully!');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
      #[Route('/account/change-password', name: 'app_account_change_password',methods:'GET|PATCH')]
     public function changePassword(Request $request, EntityManagerInterface $entityManager, PasswordHasherFactoryInterface $passwordEncoder): Response
    {
        $user = $this->getUser();


        $form = $this->createForm(ChangePasswordFormType::class, null, [
          'current_password_is_required' => true,
          'method' => 'PATCH'

        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $form['plainPassword']->getData())
            );

            $entityManager->flush();

            $this->addFlash('success', 'Password updated successfully!');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
