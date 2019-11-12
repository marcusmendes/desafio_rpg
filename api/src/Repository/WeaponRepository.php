<?php

namespace App\Repository;

use App\Entity\Weapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Weapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weapon[]    findAll()
 * @method Weapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }

    /**
     * Busca pelo o ultimo unique id
     *
     * @return Weapon|null
     * @throws NonUniqueResultException
     */
    public function findLastUniqueId(): ?Weapon
    {
        $query = $this
            ->createQueryBuilder('w')
            ->orderBy('w.uniqueId', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
