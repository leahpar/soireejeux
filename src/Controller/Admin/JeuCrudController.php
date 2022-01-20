<?php

namespace App\Controller\Admin;

use App\Entity\Jeu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class JeuCrudController extends AbstractCrudController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {}

    public static function getEntityFqcn(): string
    {
        return Jeu::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $action = Action::new('search_parties', 'Parties')
            ->linkToUrl(fn (Jeu $j) =>
                $this->adminUrlGenerator
                ->setController(PartieCrudController::class)
                ->setAction("index")
                ->set('filters', [
                    "jeu" => [
                        "comparison" => "=",
                        "value" => $j->id
                    ]
                ])
                ->generateUrl()
            );

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $action)
        ;
    }

    /**
     * https://symfony.com/doc/current/EasyAdminBundle/crud.html#search-and-pagination-options
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the max number of entities to display per page
            ->setPaginatorPageSize(50)
            //->showEntityActionsInlined()
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        // https://symfony.com/doc/current/EasyAdminBundle/fields.html

        yield Field\TextField::new('nom');
        yield Field\TextField::new('variante');
        yield Field\IntegerField::new('joueursMin');
        yield Field\IntegerField::new('joueursMax');

        yield Field\IntegerField::new('nbParties')
            ->onlyOnIndex();
        yield Field\DateField::new('dernierePartie')
            ->onlyOnIndex();
        yield Field\IntegerField::new('scoreMax.label')
            ->setLabel("Meilleur score")
            ->onlyOnIndex();
        yield Field\IntegerField::new('joueurMax')
            ->formatValue(fn($j) => $j
                ? ($j['joueur'] . ' ('.round($j['ratio']*100) . '%)')
                //? ($j['joueur'] . ' ('.$j['victoires'].'/'.$j['parties'] .')')
                : null)
            ->setLabel("Meilleur joueur")
            ->onlyOnIndex();
    }
}
