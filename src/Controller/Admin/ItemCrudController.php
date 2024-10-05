<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id')->hideOnForm(),

            // Champ pour le service (relation ManyToOne avec Service)
            AssociationField::new('service', 'Service associé'),

            // Champ pour l'article (relation ManyToOne avec Article)
            AssociationField::new('article_id', 'Article'),

            // Champ pour le nombre d'articles
            IntegerField::new('nombres_articles', 'Nombre d\'articles'),

            // Champ pour le prix total (MoneyField)
            MoneyField::new('total_price', 'Prix total')->setCurrency('EUR'), // Utilise l'euro ou adapte à ta devise
            
            // Champ pour le matériel (relation ManyToOne avec Material)
            AssociationField::new('material_id', 'Matériel'),

            // Champ pour la description de l'article
            TextField::new('item_description', 'Description de l\'article'),
        ];
    }
}
