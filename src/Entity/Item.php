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

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nombres_articles = null;

    #[ORM\Column]
    private ?float $total_price = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Article $article_id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Order $order_id = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
