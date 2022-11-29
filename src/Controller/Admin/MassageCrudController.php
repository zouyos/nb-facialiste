<?php

namespace App\Controller\Admin;

use App\Entity\Massage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MassageCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Massage::class;
  }

  /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
