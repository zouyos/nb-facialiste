<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/membres')]
class UserController extends AbstractController
{
  #[Route('/', name: 'app_user_index', methods: ['GET'])]
  public function index(UserRepository $userRepository): Response
  {
    return $this->render('user/index.html.twig', [
      'users' => $userRepository->findBy([], ['nom' => 'ASC']),
    ]);
  }

  #[Route('/modifier/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, User $user, UserRepository $userRepository): Response
  {
    $form = $this->createForm(RegistrationFormType::class, $user, [
      'sexe' => true,
      'nom' => true,
      'prenom' => true,
      'email' => true,
      'roles' => true,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $user->setModifiedAt(new \DateTimeImmutable('now'));
      $userRepository->save($user, true);
      $this->addFlash('success', 'L\'utilisateur a bien été modifié');

      return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('user/edit.html.twig', [
      'user' => $user,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
  public function delete(Request $request, User $user, UserRepository $userRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
      $userRepository->remove($user, true);
    }
    $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

    return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
  }
}
