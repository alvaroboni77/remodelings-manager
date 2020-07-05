<?php

namespace App\Repository;

use App\Entity\CertificationReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CertificationReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method CertificationReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method CertificationReport[]    findAll()
 * @method CertificationReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertificationReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CertificationReport::class);
    }

    // /**
    //  * @return CertificationReport[] Returns an array of CertificationReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CertificationReport
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
