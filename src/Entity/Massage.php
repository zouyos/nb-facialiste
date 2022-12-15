<?php

namespace App\Entity;

use App\Repository\MassageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MassageRepository::class)]
#[Vich\Uploadable]
class Massage
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank(message: 'Veuillez renseigner un titre')]
  private ?string $titre = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $photoName = null;

  #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'photoName')]
  private ?File $photoFile = null;

  #[ORM\Column(nullable: true)]
  private ?float $prix = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  private ?string $descriptionLongue = null;

  #[ORM\Column(type: Types::TIME_MUTABLE)]
  #[Assert\NotNull(message: 'Veuillez choisir une durée valide')]
  private ?\DateTimeInterface $duree = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank(message: 'Veuillez renseigner une courte description')]
  private ?string $descriptionCourte = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $modifiedAt = null;

  #[ORM\Column(length: 50, nullable: true)]
  private ?string $legende = null;


  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitre(): ?string
  {
    return $this->titre;
  }

  public function setTitre(string $titre): self
  {
    $this->titre = $titre;

    return $this;
  }

  public function getPhotoName(): ?string
  {
    return $this->photoName;
  }

  public function setPhotoName(?string $photoName): self
  {
    $this->photoName = $photoName;

    return $this;
  }

  /**
   * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
   */
  public function setPhotoFile(?File $photoFile = null): void
  {
    $this->photoFile = $photoFile;

    if (null !== $photoFile) {
      // It is required that at least one field changes if you are using doctrine
      // otherwise the event listeners won't be called and the file is lost
      $this->modifiedAt = new \DateTimeImmutable();
    }
  }

  public function getPhotoFile(): ?File
  {
    return $this->photoFile;
  }

  public function getPrix(): ?float
  {
    return $this->prix;
  }

  public function setPrix(float $prix): self
  {
    $this->prix = $prix;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(?\DateTimeImmutable $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getModifiedAt(): ?\DateTimeImmutable
  {
    return $this->modifiedAt;
  }

  public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
  {
    $this->modifiedAt = $modifiedAt;

    return $this;
  }

  public function getDuree(): ?\DateTimeInterface
  {
    return $this->duree;
  }

  public function setDuree(?\DateTimeInterface $duree): self
  {
    $this->duree = $duree;

    return $this;
  }

  public function getDescriptionLongue(): ?string
  {
    return $this->descriptionLongue;
  }

  public function setDescriptionLongue(string $descriptionLongue): self
  {
    $this->descriptionLongue = $descriptionLongue;

    return $this;
  }

  public function getLegende(): ?string
  {
    return $this->legende;
  }

  public function setLegende(?string $legende): self
  {
    $this->legende = $legende;

    return $this;
  }

  public function getDescriptionCourte(): ?string
  {
    return $this->descriptionCourte;
  }

  public function setDescriptionCourte(string $descriptionCourte): self
  {
    $this->descriptionCourte = $descriptionCourte;

    return $this;
  }
}
