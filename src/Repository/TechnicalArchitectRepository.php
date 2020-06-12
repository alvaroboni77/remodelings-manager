<?php

namespace App\Repository;

use App\Entity\TechnicalArchitect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TechnicalArchitect|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalArchitect|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalArchitect[]    findAll()
 * @method TechnicalArchitect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalArchitectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalArchitect::class);
    }

    // /**
    //  * @return TechnicalArchitect[] Returns an array of TechnicalArchitect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechnicalArchitect
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
