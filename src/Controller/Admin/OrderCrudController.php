<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Association;
use EasyCorp\Bundle\EasyAdminBundle\Field\Id;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    // public function configureFields(string $pageName): iterable
    // {
        // return [
        //     Id::new('id')->setDisabled(true),
        //     Association::new('user')->setRequired(true), // L'utilisateur qui a passé la commande
        //     Association::new('employe'), // Employé à attribuer
        //     // Ajoute d'autres champs si nécessaire
        // ];
    // }




    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
