<?php

namespace App\Repository;

use App\Entity\CharacterWeapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CharacterWeapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterWeapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterWeapon[]    findAll()
 * @method CharacterWeapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterWeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterWeapon::class);
    }
}
