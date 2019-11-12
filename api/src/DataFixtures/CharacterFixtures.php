<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\CharacterWeapon;
use App\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CharacterFixtures
 *
 * @package App\DataFixtures
 * @author  Marcus Maciel <marcusmaciel@intranet>
 */
class CharacterFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->createHuman($manager);
        $this->createOrc($manager);
    }

    /**
     * Persiste os dados do personagem Humano no banco de dados
     *
     * @param ObjectManager $manager ObjectManager
     * @return void
     */
    private function createHuman(ObjectManager $manager): void
    {
        $weaponHuman = new Weapon();
        $weaponHuman
            ->setName('Espada Longa')
            ->setAmountAttack(2)
            ->setAmountDamage(0)
            ->setAmountDefense(1);

        $characterHuman = new Character();
        $characterHuman
            ->setName('Humano')
            ->setAmountLife(12)
            ->setAmountAgility(2)
            ->setAmountStrength(1);

        $characterWeaponHuman = new CharacterWeapon();
        $characterWeaponHuman
            ->setCharacter($characterHuman)
            ->setWeapon($weaponHuman);

        $characterHuman->setCharacterWeapon($characterWeaponHuman);

        $manager->persist($characterHuman);
        $manager->flush();
    }

    /**
     * Persiste os dados do personagem Orc no banco de dados
     *
     * @param ObjectManager $manager ObjectManager
     * @return void
     */
    private function createOrc(ObjectManager $manager): void
    {
        $weaponOrc = new Weapon();
        $weaponOrc
            ->setName('Clava de Madeira')
            ->setAmountAttack(1)
            ->setAmountDamage(0)
            ->setAmountDefense(0);

        $characterOrc = new Character();
        $characterOrc
            ->setName('Orc')
            ->setAmountLife(20)
            ->setAmountAgility(0)
            ->setAmountStrength(2);

        $characterWeaponOrc = new CharacterWeapon();
        $characterWeaponOrc
            ->setCharacter($characterOrc)
            ->setWeapon($weaponOrc);

        $characterOrc->setCharacterWeapon($characterWeaponOrc);

        $manager->persist($characterOrc);
        $manager->flush();
    }
}
