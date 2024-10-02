<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ApiResource()]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $paiement_effect = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Employe $employe_id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user_id = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'order_id')]
    private Collection $items;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Status $status_id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Paiement $paiement_id = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPaiementEffect(): ?bool
    {
        return $this->paiement_effect;
    }

    public function setPaiementEffect(bool $paiement_effect): static
    {
        $this->paiement_effect = $paiement_effect;

        return $this;
    }

    public function getEmployeId(): ?Employe
    {
        return $this->employe_id;
    }

    public function setEmployeId(?Employe $employe_id): static
    {
        $this->employe_id = $employe_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

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
            $item->setOrderId($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderId() === $this) {
                $item->setOrderId(null);
            }
        }

        return $this;
    }

    public function getStatusId(): ?Status
    {
        return $this->status_id;
    }

    public function setStatusId(?Status $status_id): static
    {
        $this->status_id = $status_id;

        return $this;
    }

    public function getPaiementId(): ?Paiement
    {
        return $this->paiement_id;
    }

    public function setPaiementId(?Paiement $paiement_id): static
    {
        $this->paiement_id = $paiement_id;

        return $this;
    }
}
