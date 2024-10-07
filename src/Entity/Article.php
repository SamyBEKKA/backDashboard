<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource()]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $article_name = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $article_image = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $article_description = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?SousCategorie $sous_categorie_id = null;
    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'article_id')]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->article_name ?? 'Article inconnu'; // Retourne le nom de l'article ou 'Article inconnu' si null
    }
    
    public function getArticleName(): ?string
    {
        return $this->article_name;
    }

    public function setArticleName(string $article_name): static
    {
        $this->article_name = $article_name;

        return $this;
    }

    public function getArticleImage(): ?string
    {
        return $this->article_image;
    }

    public function setArticleImage(string $article_image): static
    {
        $this->article_image = $article_image;

        return $this;
    }

    public function getArticleDescription(): ?string
    {
        return $this->article_description;
    }

    public function setArticleDescription(?string $article_description): static
    {
        $this->article_description = $article_description;

        return $this;
    }

    public function getSousCategorieId(): ?SousCategorie
    {
        return $this->sous_categorie_id;
    }

    public function setSousCategorieId(?SousCategorie $sous_categorie_id): static
    {
        $this->sous_categorie_id = $sous_categorie_id;

        return $this;
    }


    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setArticleId($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getArticleId() === $this) {
                $item->setArticleId(null);
            }
        }

        return $this;
    }
}
