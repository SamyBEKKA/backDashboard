<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;

class ItemCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return $fields = [

            IdField::new('id')->hideOnForm(),

            // Champ pour le service (relation ManyToOne avec Service)
            AssociationField::new('service', 'Service associé'),

            // Champ pour l'article (relation ManyToOne avec Article)
            AssociationField::new('article_id', 'Article'), 
            
            // Champ pour le matériel (relation ManyToOne avec Material)
            AssociationField::new('material_id', 'Matériel'),

            // Champ pour le prix total (MoneyField)
            MoneyField::new('total_price', 'Prix total')->setCurrency('EUR'),

            // Champ pour la description de l'article
            TextField::new('item_description', 'Description de l\'article'),
        ];

        // Si l'utilisateur a le rôle "ROLE_EMPLOYE", on rend les champs en mode lecture seule
        if ($this->security->isGranted('ROLE_EMPLOYE')) {
            foreach ($fields as $field) {
                $field->setFormTypeOption('disabled', true); // Rend le champ non modifiable
            }
        }
    }
    public function configureActions(Actions $actions): Actions
    {
        // Désactiver les actions de création et de suppression pour les employés
        if ($this->security->isGranted('ROLE_EMPLOYE')) {
            return $actions->disable(
                Action::NEW,
                Action::DELETE,
                Action::EDIT
            );
        }

        return parent::configureActions($actions);
    }
}
