<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 50, nullable: true)]
  private ?string $nom = null;

  #[ORM\Column(length: 50, nullable: true)]
  private ?string $prenom = null;

  #[ORM\Column(length: 180)]
  #[Assert\Email()]
  #[Assert\NotBlank(message: 'Veuillez renseigner un email')]
  private ?string $email = null;

  #[ORM\Column(length: 100, nullable: true)]
  #[Assert\Length(
    max: 100,
    maxMessage: 'Le sujet ne peut pas excéder {{ limit }} caractères',
  )]
  private ?string $sujet = null;

  #[ORM\Column(type: Types::TEXT)]
  #[Assert\NotBlank(message: 'Le contenu du message ne peut être vide')]
  #[Assert\Length(
    min: 15,
    minMessage: 'Le message doit comporter au minimum {{ limit }} caractères',
  )]
  private ?string $message = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNom(): ?string
  {
    return $this->nom;
  }

  public function setNom(?string $nom): self
  {
    $this->nom = $nom;

    return $this;
  }

  public function getPrenom(): ?string
  {
    return $this->prenom;
  }

  public function setPrenom(?string $prenom): self
  {
    $this->prenom = $prenom;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getSujet(): ?string
  {
    return $this->sujet;
  }

  public function setSujet(?string $sujet): self
  {
    $this->sujet = $sujet;

    return $this;
  }

  public function getMessage(): ?string
  {
    return $this->message;
  }

  public function setMessage(string $message): self
  {
    $this->message = $message;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }
}
