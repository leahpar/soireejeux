<?php

namespace App\Repository;

use App\Entity\Jeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeu[]    findAll()
 * @method Jeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeu::class);
    }

    /**
     * @return Jeu[] Returns an array of Jeu objects
     */
    public function findForNbJoueurs(int $joueurs)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.joueursMin <= :val')
            ->andWhere('j.joueursMax >= :val')
            ->setParameter('val', $joueurs)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Jeu
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}