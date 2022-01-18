<?php

namespace App\Controller\Admin;

use App\Entity\Jeu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class JeuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Jeu::class;
    }

    /**
     * https://symfony.com/doc/current/EasyAdminBundle/crud.html#search-and-pagination-options
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the max number of entities to display per page
            ->setPaginatorPageSize(50)
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
    }
}
