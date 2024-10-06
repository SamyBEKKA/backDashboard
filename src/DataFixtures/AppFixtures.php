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
            ['id'=>'1','article_name' => 'Haut',],
            ['id'=>'2','article_name' => 'Bas'],
            ['id'=>'3','article_name' => 'Robe'],
            ['id'=>'4','article_name' => 'Sous-vêtement'],
        ];

        foreach ($articlesData as $data) {
            $article = new Article();
            $article->setArticleName($data['article_name']);
            $manager->persist($article);
        }

        // Création des matériaux
        $materials = [
           ['id'=>'1', 'material_name'=>'Coton'],
           ['id'=>'2', 'material_name'=>'Cuir'],
           ['id'=>'3', 'material_name'=>'Laine'],
           ['id'=>'4', 'material_name'=>'Soie']
        ];

        // Boucle pour créer et insérer chaque matériau
        foreach ($materials as $data) {
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
            ['id'=>'1','service_name' => 'Lavage Repassage', 'service_image' => '/assets/photo_prestation_service_hackaton_pressing_lavage_et_repassage.webp', 'service_price' => 10.99],
            ['id'=>'2','service_name' => 'Simple Repassage', 'service_image' => '/assets/photo_prestation_service_simple_repassage_hackaton_pressing.webp', 'service_price' => 5.99],
            ['id'=>'3','service_name' => 'Blanchissement', 'service_image' => '/assets/photo_prestation_service_blanchissement_hackaton_pressing.webp', 'service_price' => 14.99],
            ['id'=>'4','service_name' => 'Nettoyage Délicat', 'service_image' => '/assets/photo_prestation_service_hackaton_pressing_lavage_delicat.webp', 'service_price' => 29.99],
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
            ['id'=>'1','name_status' => 'En attente de confirmation'],
            ['id'=>'2','name_status' => 'En cour'],
            ['id'=>'3','name_status' => 'Terminé'],
            ['id'=>'4','name_status' => 'Annulé']
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