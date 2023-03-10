<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profil')]
class ProfilController extends AbstractController
{
  #[Route('/', name: 'app_profil')]
  public function index(): Response
  {
    return $this->render('profil/index.html.twig');
  }

  #[Route('/modifier', name: 'app_profil_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
  {
    $user = $this->getUser();
    $form = $this->createForm(RegistrationFormType::class, $user, [
      'nom' => true,
      'prenom' => true,
      'email' => true,
      'plainPassword' => true,
      'sexe' => true,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      if ($hasher->isPasswordValid($user, $form->get('plainPassword')->getData())) {

        $user->setModifiedAt(new \DateTimeImmutable('now'));
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'Votre profil a bien été mis à jour');
        return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
      } else {
        $this->addFlash('warning', 'Mot de passe invalide');
      }
    }

    return $this->renderForm('profil/edit.html.twig', [
      'user' => $user,
      'form' => $form
    ]);
  }

  #[Route('/modifier-mdp', name: 'app_profil_edit_password', methods: ['GET', 'POST'])]
  public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
  {
    $user = $this->getUser();

    $form = $this->createForm(RegistrationFormType::class, $user, [
      'plainPassword' => true,
      'updatePassword' => true,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $plainPassword = $form->get('plainPassword')->getData();
      $updatePassword = $form->get('updatePassword')->getData();

      // dd($form->getData());

      if ($updatePassword === $plainPassword) {
        $form->get('updatePassword')->addError(new FormError('Veuillez saisir un mot de passe différent de votre mot de passe actuel'));
      }

      if ($passwordHasher->isPasswordValid($user, $plainPassword)) {
        $user->setPassword(
          $passwordHasher->hashPassword($user, $updatePassword)
        );

        $entityManager->persist($user);
        $entityManager->flush();
        //
        $email = (new TemplatedEmail())
          ->from('no-reply@nb-facialiste.fr')
          ->to($user->getEmail())
          ->subject('Mot de passe modifié sur NB Facialiste')
          ->htmlTemplate('email/reset.html.twig')
          ->context([
            'user' => $user,
            'updatePassword' => $form->get('updatePassword')->getData(),
          ]);

        $mailer->send($email);

        $this->addFlash('success', 'Votre mot de passe a bien été modifié. Un mail de confirmation vous a été envoyé à l\'adresse suivante : ' . $user->getEmail());

        return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
      } else {
        $form->get('plainPassword')->addError(new FormError('Le mot de passe saisi est incorrect'));
      }
    }

    return $this->render('profil/password/edit.html.twig', [
      'form' => $form->createView()
    ]);
  }

  #[Route('/rendez-vous', name: 'app_rendez_vous', methods: ['GET'])]
  public function rendezvous(): Response
  {
    return $this->render('profil/rendez-vous.html.twig');
  }
}
