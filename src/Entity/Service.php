<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ApiResource()]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $service_name = null;

    #[ORM\Column(length: 255)]
    private ?string $service_image = null;

    #[ORM\Column]
    private ?float $service_price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->service_name;
    }

    public function setServiceName(string $service_name): static
    {
        $this->service_name = $service_name;

        return $this;
    }

    public function getServiceImage(): ?string
    {
        return $this->service_image;
    }

    public function setServiceImage(string $service_image): static
    {
        $this->service_image = $service_image;

        return $this;
    }

    public function getServicePrice(): ?float
    {
        return $this->service_price;
    }

    public function setServicePrice(float $service_price): static
    {
        $this->service_price = $service_price;

        return $this;
    }
}
