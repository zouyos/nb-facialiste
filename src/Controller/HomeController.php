<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Massage;
use App\Repository\ArticleRepository;
use App\Repository\MassageRepository;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  public function navbar(MassageRepository $massageRepository): Response
  {
    return $this->render('inc/_nav.html.twig', [
      'massages' => $massageRepository->findBy([], ['titre' => 'ASC'])
    ]);
  }

  #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
  public function index(SliderRepository $sliderRepository, ArticleRepository $articleRepository): Response
  {
    $slides = $sliderRepository->findBy(['status' => true], ['ordre' => 'ASC']);
    $articles = $articleRepository->findBy([], ['createdAt' => 'DESC'], 3);

    return $this->render('home/index.html.twig', [
      'slides' => $slides,
      'articles' => $articles,
    ]);
  }

  #[Route('/articles', name: 'app_articles', methods: ['GET'])]
  public function articles(ArticleRepository $articleRepository): Response
  {
    $articles = $articleRepository->findBy([], ['createdAt' => 'DESC']);

    return $this->render('home/articles/articles.html.twig', [
      'articles' => $articles
    ]);
  }

  #[Route('/article/{id}', name: 'app_article', methods: ['GET'])]
  public function article(Article $article): Response
  {
    return $this->render('home/articles/article.html.twig', [
      'article' => $article
    ]);
  }

  #[Route('/prestations', name: 'app_prestations', methods: ['GET'])]
  public function prestations(MassageRepository $massageRepository): Response
  {
    $massages = $massageRepository->findBy([], ['titre' => 'ASC']);

    return $this->render('home/prestations/index.html.twig', [
      'massages' => $massages
    ]);
  }

  #[Route('/prestation/{id}', name: 'app_prestation', methods: ['GET'])]
  public function prestation_show(Massage $massage): Response
  {
    return $this->render('home/prestations/prestation.html.twig', [
      'massage' => $massage,
    ]);
  }

  #[Route('admin/panel-admin', name: 'app_admin', methods: ['GET'])]
  public function dashboard(): Response
  {
    return $this->render('admin/dashboard.html.twig');
  }

  #[Route('/mentions', name: 'app_mentions', methods: ['GET'])]
  public function mentions(): Response
  {
    return $this->render('home/mentions.html.twig');
  }

  #[Route('/confidentialite', name: 'app_confidentialite', methods: ['GET'])]
  public function confidentialite(): Response
  {
    return $this->render('home/politique.html.twig');
  }

  #[Route('/cgu', name: 'app_cgu', methods: ['GET'])]
  public function cgu(): Response
  {
    return $this->render('home/cgu.html.twig');
  }
}
