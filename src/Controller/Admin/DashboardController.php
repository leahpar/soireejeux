<?php

namespace App\Controller\Admin;

use App\Entity\Jeu;
use App\Entity\Joueur;
use App\Entity\Partie;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
        $parties = $this->em->getRepository(Partie::class)->findAll();

        $jeuxPossibles = [];
        //if ($this->request->isMethod("POST")) {
        //    $nbJoueurs = $this->request->request->get('joueurs', 0);
        //    $jeuxPossibles = $this->em->getRepository(Jeu::class)->findForNbJoueurs($nbJoueurs);
        //}

        return $this->render('admin/dashboard.html.twig', [
            'jeux' => $jeux,
            'jeux_possibles' => $jeuxPossibles,
        ]);

    }


}
