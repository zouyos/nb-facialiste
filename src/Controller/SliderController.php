<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/carrousel')]
class SliderController extends AbstractController
{
  #[Route('/', name: 'app_slider_index', methods: ['GET'])]
  public function index(SliderRepository $sliderRepository): Response
  {
    return $this->render('slider/index.html.twig', [
      'sliders' => $sliderRepository->findAll(),
    ]);
  }

  #[Route('/creer', name: 'app_slider_new', methods: ['GET', 'POST'])]
  public function new(Request $request, SliderRepository $sliderRepository): Response
  {
    $slider = new Slider();
    $form = $this->createForm(SliderType::class, $slider);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $slider->setCreatedAt(new \DateTimeImmutable('now'));
      $sliderRepository->save($slider, true);

      $this->addFlash('success', 'L\'image a bien été ajoutée');

      return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('slider/new.html.twig', [
      'slider' => $slider,
      'form' => $form,
    ]);
  }

  #[Route('/modifier/{id}', name: 'app_slider_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
  {
    $form = $this->createForm(SliderType::class, $slider);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $slider->setModifiedAt(new \DateTimeImmutable('now'));
      $sliderRepository->save($slider, true);
      $this->addFlash('success', 'L\'image a bien été modifiée');

      return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('slider/edit.html.twig', [
      'slider' => $slider,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_slider_delete', methods: ['POST'])]
  public function delete(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $slider->getId(), $request->request->get('_token'))) {
      $sliderRepository->remove($slider, true);
    }
    $this->addFlash('success', 'L\'image a bien été supprimée');

    return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
  }
}
