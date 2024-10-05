<?php

namespace App\Controller\Admin;

use App\Entity\Employe;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Paiement;
use App\Entity\Status;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class DashboardController extends AbstractDashboardController
{

    private Security $security;

    // On injecte ici la nouvelle classe Security dans le constructeur
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Hackaton du Pressing');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // yield MenuItem::linkToCrud('Order', 'fas fa-list', Order::class)->setPermission('ROLE_EMPLOYE','ROLE_ADMIN');

        // Lien vers l'entité "Commandes", accessible par les employés et les admins
        if ($this->security->isGranted('ROLE_EMPLOYE') || $this->security->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Order::class);
            yield MenuItem::linkToCrud('Items', 'fas fa-tags', Item::class);
        }

        yield MenuItem::linkToCrud('Employés', 'fas fa-users', Employe::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class)->setPermission('ROLE_ADMIN');
        
        yield MenuItem::linkToCrud('Statuts', 'fas fa-info-circle', Status::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Paiements', 'fas fa-credit-card', Paiement::class)->setPermission('ROLE_ADMIN');
    }
}
