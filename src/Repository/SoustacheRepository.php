<?php

namespace App\Repository;

use App\Entity\Soustache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Soustache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Soustache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Soustache[]    findAll()
 * @method Soustache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoustacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Soustache::class);
    }

    // /**
    //  * @return Soustache[] Returns an array of Soustache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Soustache
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
