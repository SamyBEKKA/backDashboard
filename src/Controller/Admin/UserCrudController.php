<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('user_name', 'Prénom'),
            TextField::new('user_last_name', 'Nom de famille'),
            ChoiceField::new('user_genre', 'Genre')->setChoices([
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Autres' => 'Autres',
            ]),
            DateField::new('user_birthday', 'Date de naissance'),
            EmailField::new('user_email', 'Email'),
            TextField::new('user_tel', 'Téléphone'),
            TextField::new('user_adress', 'Adresse'),
            AssociationField::new('city_id', 'Ville'),
            ChoiceField::new('user_roles', 'Rôles')->setChoices([
                'Utilisateur' => 'ROLE_USER',
            ])->allowMultipleChoices(),
        ];
    }
}
