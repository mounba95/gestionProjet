<?php

namespace App\Repository;

use App\Entity\Predecesseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Predecesseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Predecesseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Predecesseur[]    findAll()
 * @method Predecesseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PredecesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Predecesseur::class);
    }

    // /**
    //  * @return Predecesseur[] Returns an array of Predecesseur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Predecesseur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
