<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/articles')]
class ArticleController extends AbstractController
{
  #[Route('/', name: 'app_article_index', methods: ['GET'])]
  public function index(ArticleRepository $articleRepository): Response
  {
    return $this->render('article/index.html.twig', [
      'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC']),
    ]);
  }

  #[Route('/creer', name: 'app_article_new', methods: ['GET', 'POST'])]
  public function new(Request $request, ArticleRepository $articleRepository): Response
  {
    $article = new Article();
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $article->setCreatedAt(new \DateTimeImmutable('now'));
      $articleRepository->save($article, true);

      $this->addFlash('success', 'L\'article a bien été ajouté');
      return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('article/new.html.twig', [
      'article' => $article,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
  public function show(Article $article): Response
  {
    return $this->render('article/show.html.twig', [
      'article' => $article,
    ]);
  }

  #[Route('/modifier/{id}', name: 'app_article_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
  {
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $article->setModifiedAt(new \DateTimeImmutable('now'));
      $articleRepository->save($article, true);

      $this->addFlash('success', 'L\'article a bien été modifié');
      return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('article/edit.html.twig', [
      'article' => $article,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
  public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
      $articleRepository->remove($article, true);
    }

    $this->addFlash('success', 'L\'article a bien été supprimé');
    return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
  }
}
