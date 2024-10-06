<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class OrderCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    // Gérer quels champs sont visibles et modifiables selon les rôles
    public function configureFields(string $pageName): iterable
    {
        // Tous les champs visibles, mais pas modifiables par l'employé
        $fields = [
            IdField::new('id')->hideOnForm(), // ID visible, non modifiable
            BooleanField::new('paiement_effect', 'Paiement Effectué'),
            AssociationField::new('employe_id', 'Employé'),
            AssociationField::new('user_id', 'Client'),
            DateField::new('order_date_depot', 'Date de dépôt')->setFormTypeOption('disabled', false), // Désactive la modification manuelle
            AssociationField::new('items', 'Panier du client')
                ->setFormTypeOptions([
                    'by_reference' => true, // Nécessaire pour la gestion des collections ManyToMany ou OneToMany
                ])
                ->setFormTypeOption('multiple', true) // Permet de sélectionner plusieurs items
                // Personnalisation de l'affichage des items dans la vue liste/détail
                ->formatValue(function ($value, $entity) {
                    // Transformer la collection d'items en une chaîne lisible
                    return implode('<br>', $entity->getItems()->map(function ($item) {
                        // Concatenation des informations sur chaque item
                        return sprintf(
                            'Service: %s, | Article: %s, | Matériel: %s, | Description: %s',
                            $item->getService() ? $item->getService()->getServiceName() : 'Aucun service',
                            $item->getArticleId() ? $item->getArticleId()->getArticleName() : 'Aucun article',
                            $item->getMaterialId() ? $item->getMaterialId()->getMaterialName() : 'Aucun matériel',
                            $item->getItemDescription() ? $item->getItemDescription() : 'Pas de description'
                        );
                    })->toArray());
                }),                
            AssociationField::new('paiement_id', 'Mode de Paiement'),
        ];

        // Champ que l'employé peut modifier
        $statusField = AssociationField::new('status_id', 'Statut de la Commande');

        // Si l'utilisateur est un employé et qu'il édite une commande, il ne peut modifier que le statut
        if ($this->security->isGranted('ROLE_EMPLOYE') && $pageName === Crud::PAGE_EDIT) {
            return [
                $statusField // Seul le statut est modifiable pour les employés
            ];
        }

        // Si l'utilisateur est un admin, il peut modifier tous les champs
        return array_merge($fields, [$statusField]);
    }


    // Restreindre les actions pour les employés
    public function configureActions(Actions $actions): Actions
    {
        // Les employés ne peuvent pas créer ou supprimer des commandes, seulement modifier (edit)
        if ($this->security->isGranted('ROLE_EMPLOYE')) {
            return $actions->disable(Action::NEW, Action::DELETE); // Désactive la création et la suppression pour les employés
        }

        // Les admins peuvent faire toutes les actions
        return parent::configureActions($actions);
    }

    // Liste des items associés à la commande (OneToMany avec Item)
            // CollectionField::new('items', 'Panier du client')
            //     ->useEntryCrudForm(ItemCrudController::class) // Utilise un autre CRUD pour gérer chaque item
            //     ->allowAdd()  // Permet l'ajout d'items
            //     ->allowDelete(),  // Permet la suppression d'items
            // Champ pour sélectionner un ou plusieurs Items déjà existants
}
