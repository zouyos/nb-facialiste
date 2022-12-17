<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ContactType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
    ->add('email', EmailType::class, [
      'required' => false,
    ])
    ->add('prenom', TextType::class, [
      'required' => false,
      'label' => 'Prénom (Facultatif)'
    ])
      ->add('nom', TextType::class, [
        'required' => false,
        'label' => 'Nom (Facultatif)'
      ])
      ->add('sujet', TextType::class, [
        'required' => false,
        'label' => 'Sujet (Facultatif)'
      ])
      ->add('message', TextareaType::class, [
        'required' => false,
        'attr' => [
          'placeholder' => 'Votre message...',
          'rows' => 6
        ]
      ])
      ->add('captcha', Recaptcha3Type::class, [
        'constraints' => new Recaptcha3(),
        'action_name' => 'contact',
        'locale' => 'fr',
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Contact::class,
    ]);
  }
}
