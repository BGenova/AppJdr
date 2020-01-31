<?php

namespace App\Repository;

use App\Entity\VocalServer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VocalServer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VocalServer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VocalServer[]    findAll()
 * @method VocalServer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VocalServerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VocalServer::class);
    }

    // /**
    //  * @return VocalServer[] Returns an array of VocalServer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VocalServer
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
