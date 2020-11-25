<?php

namespace App\Repository;

use App\Entity\Posts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    /**
     * Returns all Posts per page
     */
    public function getPaginatedPosts($page, $limit)
    {
        $query = $this->createQueryBuilder('p')
        ->orderBy('p.created_at')
        ->setFirstResult(($page * $limit) - $limit)
        ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of Posts
     */
    public function getTotalPosts()
    {
        $query = $this->createQueryBuilder('p')->select('COUNT(p)');

        return $query->getQuery()->getSingleScalarResult();
    }

    // public function findOneBySomeField($value): ?Posts
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

}
