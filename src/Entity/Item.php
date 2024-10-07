<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource()]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nombres_articles = null;

    #[ORM\Column(nullable: true)]
    private ?float $total_price = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Article $article_id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Order $order_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $item_description = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Material $material_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return sprintf(
            'Service: %s, Article: %s, Matériel: %s, Prix total: %.2f€, Description: %s',
            $this->service ? $this->service->__toString() : 'Aucun service', // Si le service est null, afficher 'Aucun service'
            $this->article_id ? $this->article_id->__toString() : 'Aucun article', // Si l'article est null, afficher 'Aucun article'
            $this->material_id ? $this->material_id->__toString() : 'Aucun matériel', // Si le matériel est null, afficher 'Aucun matériel'
            $this->total_price ?? 0, // Si le prix total est null, afficher 0
            $this->item_description ?? 'Aucune description' // Si la description est null, afficher 'Aucune description'
        );
    }

    public function getNombresArticles(): ?int
    {
        return $this->nombres_articles;
    }

    public function setNombresArticles(int $nombres_articles): static
    {
        $this->nombres_articles = $nombres_articles;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): static
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getArticleId(): ?Article
    {
        return $this->article_id;
    }

    public function setArticleId(?Article $article_id): static
    {
        $this->article_id = $article_id;

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(?Order $order_id): static
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getItemDescription(): ?string
    {
        return $this->item_description;
    }

    public function setItemDescription(?string $item_description): static
    {
        $this->item_description = $item_description;

        return $this;
    }

    public function getMaterialId(): ?Material
    {
        return $this->material_id;
    }

    public function setMaterialId(?Material $material_id): static
    {
        $this->material_id = $material_id;

        return $this;
    }
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTotalPrice(): void
    {
        // Transférer automatiquement le prix du service dans total_price
        if ($this->service) {
            $this->total_price = $this->service->getServicePrice();
        }
    }
}
