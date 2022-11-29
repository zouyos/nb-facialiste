<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Massage;
use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
  #[IsGranted('ROLE_ADMIN')]
  #[Route('/admin', name: 'admin')]
  public function index(): Response
  {
    return $this->render('admin/index.html.twig');
    // return parent::index();

    // Option 1. You can make your dashboard redirect to some common page of your backend
    //
    // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
    // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

    // Option 2. You can make your dashboard redirect to different pages depending on the user
    //
    // if ('jane' === $this->getUser()->getUsername()) {
    //     return $this->redirect('...');
    // }

    // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
    // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
    //
    // return $this->render('some/path/my-dashboard.html.twig');
  }

  public function configureDashboard(): Dashboard
  {
    return Dashboard::new()
      ->setTitle('Interface Admin');
  }

  public function configureMenuItems(): iterable
  {
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('MassageCrudController', 'fas fa-spa', Massage::class);
    yield MenuItem::linkToCrud('ArticleCrudController', 'fas fa-file-lines', Article::class);
    yield MenuItem::linkToCrud('SliderCrudController', 'fas fa-image', Slider::class);
  }
}
