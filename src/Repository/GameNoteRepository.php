<?php

namespace App\Repository;

use App\Entity\GameNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameNote[]    findAll()
 * @method GameNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameNote::class);
    }

    // /**
    //  * @return GameNote[] Returns an array of GameNote objects
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
    public function findOneBySomeField($value): ?GameNote
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
