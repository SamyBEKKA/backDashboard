<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Employe;
use App\Entity\Material;
use App\Entity\Paiement;
use App\Entity\Service;
use App\Entity\Status;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des articles
        $articlesData = [
            ['article_name' => 'Haut', 
            'article_image' => 'https://example.com/image-haut.jpg', 
            'article_description' => 'Un haut élégant'],
            ['article_name' => 'Bas', 
            'article_image' => 'https://example.com/image-bas.jpg', 
            'article_description' => 'Des bas confortables'],
            ['article_name' => 'Robe', 'article_image' => 'https://example.com/image-robe.jpg', 
            'article_description' => 'Une robe chic'],
            ['article_name' => 'Sous-vêtement', 
            'article_image' => 'https://example.com/image-sous-vetement.jpg', 
            'article_description' => 'Sous-vêtements de qualité'],
        ];

        foreach ($articlesData as $data) {
            $article = new Article();
            $article->setArticleName($data['article_name']);
            $article->setArticleImage($data['article_image']);
            $article->setArticleDescription($data['article_description']);
            $manager->persist($article);
        }

        // Définition des matériaux à insérer dans la base de données
        $materials = [
            'Coton',
            'Cuir',
            'Laine',
            'Soie'
        ];

        // Boucle pour créer et insérer chaque matériau
        foreach ($materials as $materialName) {
            $material = new Material();
            $material->setMaterialName($materialName); // Assure-toi que le setter s'appelle bien setMaterialName
            $manager->persist($material); // On persiste chaque matériau
        }

        // Création des matériaux
        $materialsData = [
            ['material_name' => 'Coton'],
            ['material_name' => 'Cuir'],
        ];

        foreach ($materialsData as $data) {
            $material = new Material();
            $material->setMaterialName($data['material_name']);
            $manager->persist($material);
        }

        // Création des pays
        $country = new Country();
        $country->setCountryName('France');
        $manager->persist($country);

        $otherCountry = new Country();
        $otherCountry->setCountryName('Autres');
        $manager->persist($otherCountry);

        // Création des villes
        $lyon = new City();
        $lyon->setCityName('Lyon');
        $lyon->setCityCp('69000');
        $lyon->setCountryId($country); // Liaison avec France
        $manager->persist($lyon);

        $saintEtienne = new City();
        $saintEtienne->setCityName('Saint-Etienne');
        $saintEtienne->setCityCp('42000');
        $saintEtienne->setCountryId($country); // Liaison avec France
        $manager->persist($saintEtienne);

        // Création des services
        $servicesData = [
            ['service_name' => 'Lavage Repassage', 'service_image' => 'https://example.com/lavage.jpg', 'service_price' => 25.99],
            ['service_name' => 'Simple Repassage', 'service_image' => 'https://example.com/repassage.jpg', 'service_price' => 19.99],
            ['service_name' => 'Blanchissement', 'service_image' => 'https://example.com/blanchissement.jpg', 'service_price' => 34.99],
            ['service_name' => 'Nettoyage Délicat', 'service_image' => 'https://example.com/nettoyage.jpg', 'service_price' => 49.99],
        ];

        foreach ($servicesData as $data) {
            $service = new Service();
            $service->setServiceName($data['service_name']);
            $service->setServiceImage($data['service_image']);
            $service->setServicePrice($data['service_price']);
            $manager->persist($service);
        }

        // Création des utilisateurs
        $user = new User();
        $user->setUserName('user');
        $user->setUserLastName('resu');
        $user->setUserGenre(1);
        $user->setUserBirthday(new \DateTime('08-12-2001'));
        $user->setUserAdress('1 Rue chez Mario');
        $user->setUserTel('+330684755235');
        $user->setUserEmail('user@example.com');
        $user->setPassword('password'); // Le mot de passe sera hashé par l'EventListener
        $user->setUserRoles(['ROLE_USER']);
        $user->setCityId($saintEtienne);
        $manager->persist($user);

        $admin = new Employe();
        $admin->setUserName('cople');
        $admin->setUserLastName('doble');
        $admin->setEmployePseudo('admin');
        $admin->setUserEmail('admin@mail.com');
        $admin->setPassword('password');
        $admin->setUserRoles(['ROLE_ADMIN']);
        $admin->setUserAdress('1 Rue chez Mario');
        $admin->setUserTel('+330684755235');
        $admin->setUserGenre(2);
        $admin->setUserBirthday(new \DateTime('08-12-2005'));
        $manager->persist($admin);

        $employe = new Employe();
        $employe->setUserName('solo');
        $employe->setUserLastName('olos');
        $employe->setEmployePseudo('employe');
        $employe->setUserEmail('employe@mail.com');
        $employe->setPassword('password');
        $employe->setUserRoles(['ROLE_EMPLOYE']);
        $employe->setUserAdress('1 Rue chez Mario');
        $employe->setUserTel('+330684755235');
        $employe->setUserGenre(2);
        $employe->setUserBirthday(new \DateTime('08-12-2005'));
        $manager->persist($employe);

        $statusType = [
            ['name_status' => 'En attente de confirmation'],
            ['name_status' => 'En cour'],
            ['name_status' => 'Terminé'],
            ['name_status' => 'Annulé']
        ];
        foreach($statusType as $data){
            $status = new Status();
            $status->setNameStatus($data['name_status']);
            $manager->persist($status);
        }
        
        $paiementType = [
            ['paiement_method' => 'Carte bancaire'],
            ['paiement_method' => 'PayPal'],
            ['paiement_method' => 'Apple Pay']
        ];

        foreach($paiementType as $data){
            $paiement = new Paiement();
            $paiement->setPaiementMethod($data['paiement_method']);
            $manager->persist($paiement);
        };
        // Enregistrer tous les changements dans la base de données
        $manager->flush();
    }
}