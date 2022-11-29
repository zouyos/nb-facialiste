<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 100)]
  #[Assert\NotBlank(message: 'Veuillez renseigner un titre')]
  private ?string $titre = null;

  #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
  private Collection $article;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $modifiedAt = null;

  public function __construct()
  {
    $this->article = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitre(): ?string
  {
    return $this->titre;
  }

  public function setTitre(?string $titre): self
  {
    $this->titre = $titre;

    return $this;
  }

  /**
   * @return Collection<int, Article>
   */
  public function getArticle(): Collection
  {
    return $this->article;
  }

  public function addArticle(Article $article): self
  {
    if (!$this->article->contains($article)) {
      $this->article->add($article);
      $article->setCategorie($this);
    }

    return $this;
  }

  public function removeArticle(Article $article): self
  {
    if ($this->article->removeElement($article)) {
      // set the owning side to null (unless already changed)
      if ($article->getCategorie() === $this) {
        $article->setCategorie(null);
      }
    }

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
