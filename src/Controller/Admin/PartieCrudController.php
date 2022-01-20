<?php

namespace App\Controller\Admin;

use App\Entity\Partie;
use App\Form\ScoreType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class PartieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field\DateField::new('date');
        yield Field\AssociationField::new('jeu');
        yield Field\CollectionField::new('scores')
            ->onlyOnForms()
            ->allowAdd()
            ->allowDelete()
            ->setEntryIsComplex(true)
            ->setEntryType(ScoreType::class)
            ->setFormTypeOptions([
                'by_reference' => 'true'
            ]);
        yield Field\IntegerField::new('joueurs')
            ->onlyOnIndex();
        yield Field\TextField::new('resultat')
            ->onlyOnIndex();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('jeu')
            ;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->persist($entityInstance);
        foreach ($entityInstance->scores as $score) {
            $score->partie = $entityInstance;
        }
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->persist($entityInstance);
        foreach ($entityInstance->scores as $score) {
            $score->partie = $entityInstance;
        }
        $entityManager->flush();
    }
}
