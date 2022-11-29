<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/categorie')]
class CategorieController extends AbstractController
{
  #[Route('/', name: 'app_categorie_index', methods: ['GET'])]
  public function index(CategorieRepository $categorieRepository): Response
  {
    return $this->render('categorie/index.html.twig', [
      'categories' => $categorieRepository->findAll(),
    ]);
  }

  #[Route('/creer', name: 'app_categorie_new', methods: ['GET', 'POST'])]
  public function new(Request $request, CategorieRepository $categorieRepository): Response
  {
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $categorie->setCreatedAt(new \DateTimeImmutable('now'));
      $categorieRepository->save($categorie, true);

      $this->addFlash('success', 'La catégorie a bien été créée');

      return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('categorie/new.html.twig', [
      'categorie' => $categorie,
      'form' => $form,
    ]);
  }

  #[Route('/modifier/{id}', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
  {
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $categorie->setModifiedAt(new \DateTimeImmutable('now'));
      $categorieRepository->save($categorie, true);

      $this->addFlash('success', 'La catégorie a bien été modifiée');

      return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('categorie/edit.html.twig', [
      'categorie' => $categorie,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_categorie_delete', methods: ['POST'])]
  public function delete(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {
      $categorieRepository->remove($categorie, true);
    }

    $this->addFlash('success', 'La catégorie a bien été supprimée');

    return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
  }
}
