<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
  #[Route('/inscription', name: 'app_register')]
  public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
  {
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user, [
      'email' => true,
      'plainPassword' => true,
      'nom' => true,
      'prenom' => true,
      'sexe' => true,
      'agreeTerms' => true,
      // 'roles' => true,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // encode the plain password
      $user->setPassword(
        $userPasswordHasher->hashPassword(
          $user,
          $form->get('plainPassword')->getData()
        )
      );

      $user->setCreatedAt(new \DateTimeImmutable('now'));
      $entityManager->persist($user);
      $entityManager->flush();
      // do anything else you need here, like send an email
      $email = (new TemplatedEmail())
        ->from('no-reply@nb-facialiste.fr')
        ->to($user->getEmail())
        ->subject('Vos identifiants de connexion sur NB Facialiste')
        ->htmlTemplate('email/register.html.twig')
        ->context([
          'user' => $user,
          'plainPassword' => $form->get('plainPassword')->getData(),
        ]);

      $mailer->send($email);

      $this->addFlash('success', 'Votre compte a bien été créé !
      Un email de confirmation vous a été envoyé à l\'adresse : ' . $user->getEmail());

      return $userAuthenticator->authenticateUser(
        $user,
        $authenticator,
        $request
      );
    }

    return $this->render('registration/register.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
  }
}
