<?php

namespace App\Controller\Admin;

use App\Entity\Jeu;
use App\Entity\Joueur;
use App\Entity\Partie;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
        private EntityManagerInterface $em,
    ) {}

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Soireejeux')
            ->disableUrlSignatures()
            ->generateRelativeUrls()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Jeux', 'fas fa-gamepad', Jeu::class);
        yield MenuItem::linkToCrud('Joueurs', 'fas fa-ghost', Joueur::class);
        yield MenuItem::linkToCrud('Parties', 'fas fa-trophy', Partie::class);
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $jeux = $this->em->getRepository(Jeu::class)->findAll();
        //$parties = $this->em->getRepository(Partie::class)->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'jeux' => $jeux,
        ]);
    }

    #[Route('/admin/choisir-un-jeu', name: 'choisir_un_jeu', methods: ["POST"])]
    public function choisirJeu(Request $request)
    {
        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(JeuCrudController::class)
                ->setAction("index")
                ->set('filters', [
                    "joueursMin" => [
                        "comparison" => "<=",
                        "value" => $request->get('joueurs')
                    ],
                    "joueursMax" => [
                        "comparison" => ">=",
                        "value" => $request->get('joueurs')
                    ]
                ])
                ->generateUrl()
        );
    }


}
