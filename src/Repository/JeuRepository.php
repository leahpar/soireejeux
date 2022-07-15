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
    public function findJeuxOrderByParties()
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.parties', 'p')
            ->addSelect('count(p.id) AS HIDDEN cpt')
            ->groupBy('j.id')
            ->orderBy('cpt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
