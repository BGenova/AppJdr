<?php

namespace App\Repository;

use App\Entity\GameSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameSlide|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameSlide|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameSlide[]    findAll()
 * @method GameSlide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameSlideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameSlide::class);
    }

    // /**
    //  * @return GameSlide[] Returns an array of GameSlide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameSlide
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
