<?php

namespace App\Repository;

use App\Entity\RecycleCenter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecycleCenter|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecycleCenter|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecycleCenter[]    findAll()
 * @method RecycleCenter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecycleCenterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecycleCenter::class);
    }

    // /**
    //  * @return RecycleCenter[] Returns an array of RecycleCenter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecycleCenter
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
