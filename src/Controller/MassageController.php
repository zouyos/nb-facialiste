<?php

namespace App\Controller;

use App\Entity\Massage;
use App\Form\MassageType;
use App\Repository\MassageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/massages')]
class MassageController extends AbstractController
{
  #[Route('/', name: 'app_massage_index', methods: ['GET'])]
  public function index(MassageRepository $massageRepository): Response
  {
    return $this->render('massage/index.html.twig', [
      'massages' => $massageRepository->findAll(),
    ]);
  }

  #[Route('/creer', name: 'app_massage_new', methods: ['GET', 'POST'])]
  public function new(Request $request, MassageRepository $massageRepository): Response
  {
    $massage = new Massage();
    $form = $this->createForm(MassageType::class, $massage);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $massage->setCreatedAt(new \DateTimeImmutable('now'));
      $massageRepository->save($massage, true);
      $this->addFlash('success', 'La prestation a bien été créée');

      return $this->redirectToRoute('app_massage_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('massage/new.html.twig', [
      'massage' => $massage,
      'form' => $form,
    ]);
  }

  #[Route('/modifier/{id}', name: 'app_massage_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Massage $massage, MassageRepository $massageRepository): Response
  {
    $form = $this->createForm(MassageType::class, $massage);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $massage->setModifiedAt(new \DateTimeImmutable('now'));
      $massageRepository->save($massage, true);
      $this->addFlash('success', 'La prestation a bien été modifiée');

      return $this->redirectToRoute('app_massage_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('massage/edit.html.twig', [
      'massage' => $massage,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_massage_delete', methods: ['POST'])]
  public function delete(Request $request, Massage $massage, MassageRepository $massageRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $massage->getId(), $request->request->get('_token'))) {
      $massageRepository->remove($massage, true);
    }
    
    $this->addFlash('success', 'La prestation a bien été supprimée');
    
    return $this->redirectToRoute('app_massage_index', [], Response::HTTP_SEE_OTHER);
  }
}
