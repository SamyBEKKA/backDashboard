<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('user_email', message: 'Cet email est déjà utilisé.')]
#[UniqueEntity('user_tel', message: 'Ce numéro de téléphone est déjà utilisé.')]
#[ORM\Table(name: '`user`')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: "dtype", type: "string")] // data type, pour les types de données
#[ORM\DiscriminatorMap(["user" => User::class, "employe" => Employe::class])]
// #[ORM\UniqueConstraint(name: 'ID_USERNAME', fields: ['user_email'])]
#[ApiResource()]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $user_name = null;

    #[ORM\Column(length: 255)]
    private ?string $user_last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $user_genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $user_birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $user_email = null;

    #[ORM\Column(length: 15)]
    private ?string $user_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $user_adress = null;

    #[ORM\Column(length: 255)]
    private ?string $user_password = null;

    #[ORM\Column]
    private array $user_roles = [];

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?City $city_id = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'user_id')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }
    public function __toString(): string
    {
        // Combine le prénom, le nom de famille et l'email, en gérant les valeurs nulles
        return ($this->user_name ?? '') . ' ' . ($this->user_last_name ?? '') . ' (' . ($this->user_email ?? '') . ')';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): static
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->user_last_name;
    }

    public function setUserLastName(string $user_last_name): static
    {
        $this->user_last_name = $user_last_name;

        return $this;
    }

    public function getUserGenre(): ?string
    {
        return $this->user_genre;
    }

    public function setUserGenre(string $user_genre): static
    {
        $this->user_genre = $user_genre;

        return $this;
    }

    public function getUserBirthday(): ?\DateTimeInterface
    {
        return $this->user_birthday;
    }

    public function setUserBirthday(\DateTimeInterface $user_birthday): static
    {
        $this->user_birthday = $user_birthday;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): static
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getUserTel(): ?string
    {
        return $this->user_tel;
    }

    public function setUserTel(string $user_tel): static
    {
        $this->user_tel = $user_tel;

        return $this;
    }

    public function getUserAdress(): ?string
    {
        return $this->user_adress;
    }

    public function setUserAdress(string $user_adress): static
    {
        $this->user_adress = $user_adress;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->user_password;
    }

    public function setPassword(string $user_password): self
    {
        $this->user_password = $user_password;

        return $this;
    }
   
    public function getUserRoles(): array
    {
        return $this->user_roles;
    }

    public function setUserRoles(array $user_roles): static
    {
        $this->user_roles = $user_roles;

        return $this;
    }

    public function getCityId(): ?City
    {
        return $this->city_id;
    }

    public function setCityId(?City $city_id): static
    {
        $this->city_id = $city_id;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUserId($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUserId() === $this) {
                $order->setUserId(null);
            }
        }

        return $this;
    }
    
    public function getRoles(): array
    {
        $roles=$this->user_roles;
        $roles[]='ROLE_USER';
        return array_unique($roles);
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->user_email;
    }
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
