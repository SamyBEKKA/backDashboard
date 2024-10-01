<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
#[ApiResource]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $paiement_method = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaiementMethod(): ?string
    {
        return $this->paiement_method;
    }

    public function setPaiementMethod(string $paiement_method): static
    {
        $this->paiement_method = $paiement_method;

        return $this;
    }
}
