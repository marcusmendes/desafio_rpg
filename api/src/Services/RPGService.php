<?php

namespace App\Services;

use App\Entity\Character;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RPGService
 * @package App\Services
 */
class RPGService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RPGService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Inicica a rodada com os personagens humano e orc
     *
     * @return array
     */
    public function startRound(): array
    {
        $human = $this->getCharacter('c_humano');
        $orc = $this->getCharacter('c_orc');

        return [
            'human' => $human !== null ? $human->toArray() : [],
            'orc' => $orc !== null ? $orc->toArray() : []
        ];
    }

    /**
     * Retorna o personagem pelo unique_id
     *
     * @param string $uniqueId O Id unico do personagem
     * @return Character|null
     */
    private function getCharacter(string $uniqueId): ?Character
    {
        $characters = $this
            ->entityManager
            ->getRepository(Character::class)
            ->findOneBy([
                'uniqueId' => $uniqueId
            ]);

        return $characters;
    }
}
