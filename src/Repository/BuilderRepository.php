<?php

namespace App\Repository;

use App\Entity\Builder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Builder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Builder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Builder[]    findAll()
 * @method Builder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuilderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Builder::class);
    }

    // /**
    //  * @return Builder[] Returns an array of Builder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Builder
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
