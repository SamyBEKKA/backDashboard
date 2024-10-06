<?php
namespace App\EventListener;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\User;
use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(Events::prePersist)]
#[ApiResource()]
class HashUserPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        // Hachage du mot de passe pour User et pour Employe
        if ($entity instanceof User) {
            $entity->setPassword($this->hasher->hashPassword($entity, $entity->getPassword()));
        } 
        
    }
}
