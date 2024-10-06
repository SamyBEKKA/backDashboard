<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
#[UniqueEntity('employe_pseudo', message: 'Ce pseudo est déjà utilisé.')]
#[ApiResource()]
class Employe extends User
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    // #[ORM\Column(length: 255)]
    // private ?string $employe_name = null;

    // #[ORM\Column(length: 255)]
    // private ?string $employe_last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $employe_pseudo = null;

    // #[ORM\Column(length: 255)]
    // private ?string $employe_password = null;

    // #[ORM\Column]
    // private array $employe_roles = [];

    // /**
    //  * @var Collection<int, Order>
    //  */
    // #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'employe_id')]
    // private Collection $orders;

    // #[ORM\Column(length: 255)]
    // private ?string $user_email = null;

    // public function __construct()
    // {
    //     $this->orders = new ArrayCollection();
    // }
    // Méthode __toString pour renvoyer le pseudo de l'employé
    public function __toString(): string
    {
        return $this->employe_pseudo; // Retourne le pseudo de l'employé
    }
    
    public function getEmployePseudo(): ?string
    {
        return $this->employe_pseudo;
    }

    public function setEmployePseudo(string $employe_pseudo): static
    {
        $this->employe_pseudo = $employe_pseudo;

        return $this;
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // public function getEmployeName(): ?string
    // {
    //     return $this->employe_name;
    // }

    // public function setEmployeName(string $employe_name): static
    // {
    //     $this->employe_name = $employe_name;

    //     return $this;
    // }

    // public function getEmployeLastName(): ?string
    // {
    //     return $this->employe_last_name;
    // }

    // public function setEmployeLastName(string $employe_last_name): static
    // {
    //     $this->employe_last_name = $employe_last_name;

    //     return $this;
    // }

    

    // public function getPassword(): ?string
    // {
    //     return $this->employe_password;
    // }

    // public function setPassword(string $employe_password): self
    // {
    //     $this->employe_password = $employe_password;

    //     return $this;
    // }

    // public function getEmployeRoles(): array
    // {
    //     return $this->employe_roles;
    // }

    // public function setEmployeRoles(array $employe_roles): static
    // {
    //     $this->employe_roles = $employe_roles;

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Order>
    //  */
    // public function getOrders(): Collection
    // {
    //     return $this->orders;
    // }

    // public function addOrder(Order $order): static
    // {
    //     if (!$this->orders->contains($order)) {
    //         $this->orders->add($order);
    //         $order->setEmployeId($this);
    //     }

    //     return $this;
    // }

    // public function removeOrder(Order $order): static
    // {
    //     if ($this->orders->removeElement($order)) {
    //         // set the owning side to null (unless already changed)
    //         if ($order->getEmployeId() === $this) {
    //             $order->setEmployeId(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function getUserEmail(): ?string
    // {
    //     return $this->user_email;
    // }

    // public function setUserEmail(string $user_email): static
    // {
    //     $this->user_email = $user_email;

    //     return $this;
    // }

    // public function getRoles(): array
    // {
    //     $roles=$this->employe_roles;
    //     $roles[]='ROLE_EMPLOYE';
    //     return array_unique($roles);
    // }
    // public function getUserIdentifier(): string
    // {
    //     return (string) $this->employe_pseudo;
    // }
    // public function eraseCredentials(): void
    // {
    //     // If you store any temporary, sensitive data on the user, clear it here
    //     // $this->plainPassword = null;
    // }
}
