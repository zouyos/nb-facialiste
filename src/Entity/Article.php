<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[Vich\Uploadable]
class Article
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank(message: 'Veuillez renseigner un titre')]
  #[Assert\Length(
    min: 2,
    max: 255,
    minMessage: 'Le titre de l\'article doit comporter au minimum {{ limit }} caractères',
    maxMessage: 'Le titre de l\'article ne peut pas comporter plus de {{ limit }} caractères',
  )]
  private ?string $titre = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $imageName = null;

  #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
  private ?File $imageFile = null;

  #[ORM\Column(type: Types::TEXT)]
  #[Assert\NotBlank(message: 'Le contenu de l\'article ne peut être vide')]
  #[Assert\Length(
    min: 5,
    minMessage: 'Le contenu de l\'article doit comporter au minimum {{ limit }} caractères',
  )]
  private ?string $content = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $modifiedAt = null;

  #[ORM\ManyToOne(inversedBy: 'article')]
  private ?Categorie $categorie = null;

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

  public function getImageName(): ?string
  {
    return $this->imageName;
  }

  public function setImageName(?string $imageName): self
  {
    $this->imageName = $imageName;

    return $this;
  }

  /**
   * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
   */
  public function setImageFile(?File $imageFile = null): void
  {
    $this->imageFile = $imageFile;

    if (null !== $imageFile) {
      // It is required that at least one field changes if you are using doctrine
      // otherwise the event listeners won't be called and the file is lost
      $this->modifiedAt = new \DateTimeImmutable();
    }
  }

  public function getImageFile(): ?File
  {
    return $this->imageFile;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;

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

  public function getModifiedAt(): ?\DateTimeImmutable
  {
    return $this->modifiedAt;
  }

  public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
  {
    $this->modifiedAt = $modifiedAt;

    return $this;
  }

  public function getCategorie(): ?Categorie
  {
    return $this->categorie;
  }

  public function setCategorie(?Categorie $categorie): self
  {
    $this->categorie = $categorie;

    return $this;
  }
}
