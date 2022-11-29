<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SliderType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('imageFile', VichImageType::class, [
        'required' => false,
        'label' => 'Photo',
        'allow_delete' => false,
        'download_label' => false,
        'imagine_pattern' => 'resize600',
      ])
      ->add('titre', TextType::class, [
        'required' => false,
      ])
      ->add('ordre')
      ->add('status', CheckboxType::class, [
        'required' => false,
        'label' => false,
        'attr' => [
          'class' => 'form-check-input',
          'type' => 'checkbox',
          'role' => 'switch',
          'name' => 'switch',
          'id' => 'switch'
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Slider::class,
      'status' => true,
      // 'ordre' => '',
    ]);
  }
}
