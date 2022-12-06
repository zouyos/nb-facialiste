<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('sexe', ChoiceType::class, [
        'required' => false,
        'label' => 'Civilité',
        'choices' => [
          'Madame' => 'F',
          'Monsieur' => 'M',
          'Autre' => 'Non spécifié',
        ],
        'constraints' => [
          new NotBlank([
            'message' => 'Veuillez spécifier une civilité',
          ])
        ],
        "multiple" => false,
        "expanded" => false
      ])
      ->add('nom', TextType::class, [
        'required' => false,
      ])
      ->add('prenom', TextType::class, [
        'required' => false,
      ])
      ->add('email', EmailType::class, [
        'required' => false,
      ])
      ->add('password', PasswordType::class, [
        'label' => 'Mot de passe',
        'required' => false,
        'attr' => ['autocomplete' => 'new-password'],
        'constraints' => [
          new NotBlank([
            'message' => 'Vous devez renseigner un mot de passe',
          ]),
          new Length([
            'min' => 6,
            'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères.',
            // max length allowed by Symfony for security reasons
            'max' => 4096,
          ]),
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
