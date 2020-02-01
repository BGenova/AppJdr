<?php

namespace App\Repository;

use App\Entity\GameBattleMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameBattleMap|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameBattleMap|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameBattleMap[]    findAll()
 * @method GameBattleMap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameBattleMapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameBattleMap::class);
    }

    // /**
    //  * @return GameBattleMap[] Returns an array of GameBattleMap objects
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
    public function findOneBySomeField($value): ?GameBattleMap
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
