<?php

namespace App\Repository;

use App\Entity\TurnRound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TurnRound|null find($id, $lockMode = null, $lockVersion = null)
 * @method TurnRound|null findOneBy(array $criteria, array $orderBy = null)
 * @method TurnRound[]    findAll()
 * @method TurnRound[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TurnRoundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TurnRound::class);
    }

    // /**
    //  * @return TurnRound[] Returns an array of TurnRound objects
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
    public function findOneBySomeField($value): ?TurnRound
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
