<?php

namespace App\Repository;

use App\Entity\Remodeling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Remodeling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Remodeling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Remodeling[]    findAll()
 * @method Remodeling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemodelingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Remodeling::class);
    }


    /*
    public function findOneBySomeField($value): ?Remodeling
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
