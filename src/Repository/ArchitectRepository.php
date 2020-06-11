<?php

namespace App\Repository;

use App\Entity\Architect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Architect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Architect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Architect[]    findAll()
 * @method Architect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchitectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Architect::class);
    }

    // /**
    //  * @return Architect[] Returns an array of Architect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Architect
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
