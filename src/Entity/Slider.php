<?php

namespace App\Entity;

use App\Repository\SliderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SliderRepository::class)]
#[Vich\Uploadable]
class Slider
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $imageName = null;

  #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
  private ?File $imageFile = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank(message: 'Vous devez renseigner un titre')]
  private ?string $titre = null;

  #[ORM\Column(nullable: true)]
  private ?int $ordre = null;

  #[ORM\Column(nullable: true)]
  private ?bool $status = true;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $modifiedAt = null;

  public function getId(): ?int
  {
    return $this->id;
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

  public function getTitre(): ?string
  {
    return $this->titre;
  }

  public function setTitre(string $titre): self
  {
    $this->titre = $titre;

    return $this;
  }

  public function getOrdre(): ?int
  {
    return $this->ordre;
  }

  public function setOrdre(?int $ordre): self
  {
    $this->ordre = $ordre;

    return $this;
  }

  public function isStatus(): ?bool
  {
    return $this->status;
  }

  public function setStatus(?bool $status): self
  {
    $this->status = $status;

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
}
