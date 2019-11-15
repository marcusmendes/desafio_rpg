<?php

namespace App\Repository;

use App\Entity\TurnRound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

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

    /**
     * Busca pelo último turno de um round específico
     *
     * @param integer $idRound
     * @return TurnRound|null
     * @throws NonUniqueResultException
     */
    public function findLastTurnRoundWhereDamageNotNull(int $idRound): ?TurnRound
    {
        $query = $this
            ->createQueryBuilder('tr')
            ->where('tr.round = :idRound')
            ->andWhere('tr.damage IS NOT NULL')
            ->orderBy('tr.id', 'DESC')
            ->setMaxResults(1)
            ->setParameter('idRound', $idRound)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
