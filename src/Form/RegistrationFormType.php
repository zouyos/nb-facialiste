<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    if ($options['email']) {
      $builder
        ->add('email', EmailType::class, [
          'required' => false,
        ]);
    };

    if ($options['agreeTerms']) {
      $builder
        ->add('agreeTerms', CheckboxType::class, [
          'required' => false,
          'mapped' => false,
          'constraints' => [
            new IsTrue([
              'message' => 'Vous devez cocher cette case pour poursuivre l\'inscription.',
            ]),
          ],
        ]);
    }

    if ($options['plainPassword']) {
      $builder
        ->add('plainPassword', PasswordType::class, [
          // instead of being set onto the object directly,
          // this is read and encoded in the controller
          'mapped' => false,
          'required' => false,
          'label' => 'Mot de passe',
          'attr' => ['autocomplete' => 'new-password'],
          'constraints' => [
            new NotBlank([
              'message' => 'Vous devez renseigner un mot de passe',
            ]),
            new Regex([
              'pattern' => '~(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$~',
              'match' => true,
              'message' => 'Votre mot de passe doit contenir au minimum : 
              8 caractères, une lettre en majuscule, une en miniscule et un chiffre.',
            ]),
          ],
          'help' => 'Votre mot de passe doit contenir au minimum : 
          8 caractères, une lettre en majuscule, une en miniscule et un chiffre.'
        ]);
    }

    if ($options['updatePassword']) {
      $builder
        ->add('newPassword', PasswordType::class, [
          'mapped' => false,
          'required' => false,
          'label' => 'Nouveau mot de passe',
          'constraints' => [
            new Length([
              'min' => 6,
              'minMessage' => 'Le mot de passe doit contenir au minimum {{ limit }} caractères.',
              'max' => 4096,
            ]),
          ],
        ])
        ->add('confirmedPassword', PasswordType::class, [
          'mapped' => false,
          'required' => false,
          'label' => 'Confirmer nouveau mot de passe',
          'constraints' => [
            new Length([
              'min' => 6,
              'minMessage' => 'Le mot de passe doit contenir au minimum {{ limit }} caractères.',
              'max' => 4096,
            ]),
          ],
        ]);
    }

    if ($options['nom']) {
      $builder
        ->add('nom', TextType::class, [
          'required' => false,
        ]);
    }

    if ($options['prenom']) {
      $builder
        ->add('prenom', TextType::class, [
          'required' => false,
        ]);
    }

    if ($options['sexe']) {
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
        ]);
    }

    if ($options['roles']) {
      $builder
        ->add('roles', ChoiceType::class, [
          'required' => false,
          'label' => false,
          'choices' => [
            'Admin' => 'ROLE_ADMIN'
          ],
          "multiple" => true,
          "expanded" => true
        ])
        ->add('captcha', Recaptcha3Type::class, [
          'constraints' => new Recaptcha3(),
          'action_name' => 'register',
          'locale' => 'fr',
        ]);
    }
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
      'email' => false,
      'agreeTerms' => false,
      'plainPassword' => false,
      'updatePassword' => false,
      'nom' => false,
      'prenom' => false,
      'sexe' => false,
      'roles' => false
    ]);
  }
}
