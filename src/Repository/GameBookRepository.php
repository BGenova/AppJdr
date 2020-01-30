<?php

namespace App\Repository;

use App\Entity\GameBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameBook[]    findAll()
 * @method GameBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameBook::class);
    }

    // /**
    //  * @return GameBook[] Returns an array of GameBook objects
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
    public function findOneBySomeField($value): ?GameBook
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
