<?php

namespace App\Controller\Admin;

use App\Entity\Joueur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class JoueurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Joueur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field\TextField::new('nom');
        yield Field\AssociationField::new('scores', 'Parties');
    }

}
