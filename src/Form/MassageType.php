<?php

namespace App\Form;

use App\Entity\Massage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MassageType extends AbstractType
{
  public function minutes()
  {
    $minutes = [];

    for ($i = 0; $i < 60; $i += 5) {
      $minutes[] = $i;
    }
    return $minutes;
  }

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('titre', TextType::class, [
        'required' => false,
      ])
      ->add('legende', TextType::class, [
        'required' => false,
        'label' => 'Légende du Titre'
      ])
      ->add('photoFile', VichImageType::class, [
        'required' => false,
        'label' => 'Photo',
        'allow_delete' => false,
        'download_label' => false,
        'imagine_pattern' => 'resize600',
      ])
      ->add('duree', TimeType::class, [
        'required' => false,
        "hours" => [0, 1, 2],
        "minutes" => $this->minutes(),
        'label' => 'Durée',
        'placeholder' => false,
      ])
      ->add('descriptionCourte', TextType::class, [
        'required' => false,
      ])
      ->add('descriptionLongue', TextareaType::class, [
        'required' => false,
        'attr' => [
          'palceholder' => 'Votre texte...',
          'rows' => '12'
        ]
      ])
      ->add('prix', MoneyType::class, [
        'required' => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Massage::class,
    ]);
  }
}