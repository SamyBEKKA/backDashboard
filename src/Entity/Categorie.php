<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource()]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorie_image = null;

    /**
     * @var Collection<int, SousCategorie>
     */
    #[ORM\OneToMany(targetEntity: SousCategorie::class, mappedBy: 'categorie_id')]
    private Collection $sousCategories;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->categorie_name ?? 'Categorie inconnu';
    }

    public function getCategorieName(): ?string
    {
        return $this->categorie_name;
    }

    public function setCategorieName(string $categorie_name): static
    {
        $this->categorie_name = $categorie_name;

        return $this;
    }

    public function getCategorieImage(): ?string
    {
        return $this->categorie_image;
    }

    public function setCategorieImage(?string $categorie_image): static
    {
        $this->categorie_image = $categorie_image;

        return $this;
    }

    /**
     * @return Collection<int, SousCategorie>
     */
    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategory(SousCategorie $sousCategory): static
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories->add($sousCategory);
            $sousCategory->setCategorieId($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategorie $sousCategory): static
    {
        if ($this->sousCategories->removeElement($sousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCategorieId() === $this) {
                $sousCategory->setCategorieId(null);
            }
        }

        return $this;
    }
}
