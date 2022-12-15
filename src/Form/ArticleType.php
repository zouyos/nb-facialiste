<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('titre', TextType::class, [
        'required' => false,
      ])
      ->add('categorie', EntityType::class, [
        'required' => false,
        'label' => 'Catégorie',
        'placeholder' => 'Aucune',
        'class' => Categorie::class,
        'choice_label' => 'titre',
        'expanded' => true,
      ])
      ->add('imageFile', VichImageType::class, [
        'required' => false,
        'label' => 'Image',
        'allow_delete' => false,
        'download_label' => false,
        'imagine_pattern' => 'resize600',
      ])
      ->add('content', TextareaType::class, [
        'required' => false,
        'label' => false,
        'attr' => [
          'placeholder' => 'Contenu de l\'article...',
          'rows' => 12
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Article::class,
    ]);
  }
}
