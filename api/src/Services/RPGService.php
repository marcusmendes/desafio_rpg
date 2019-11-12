<?php

namespace App\Services;

use App\Entity\Character;
use App\Entity\Round;
use App\Enum\TurnStepEnum;
use App\Exceptions\ApiException;
use App\Model\RPG;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;

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
     * @throws ApiException
     */
    public function startRound(): array
    {
        try {
            $human = $this->getCharacter('c_humano');
            $orc = $this->getCharacter('c_orc');

            $round = $this->createRound();

            return [
                'round' => $round->toArray(),
                'characters' => [
                    'human' => $human !== null ? $human->toArray() : [],
                    'orc' => $orc !== null ? $orc->toArray() : []
                ]
            ];

        } catch (NonUniqueResultException $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Inicia o turno
     *
     * @param Request $request
     * @return array
     */
    public function startTurn(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $step = $content['step'];

        $characters = $content['characters'];
        $human = $this->getCharacter($characters['human']['uniqueId']);
        $orc = $this->getCharacter($characters['orc']['uniqueId']);

        if ($step === TurnStepEnum::INIATIVE) {
            $characterStart = $this->initiative($human, $orc);

            $characterStriker = null;
            $characterDefender = null;

            if ($characterStart->getUniqueId() === $human->getUniqueId()) {
                $characterStriker = $human;
                $characterDefender = $orc;
            } else {
                $characterStriker = $orc;
                $characterDefender = $human;
            }

            return [
                'step' => 'attack',
                'character_striker'  => $characterStriker->toArray(),
                'character_defender' => $characterDefender->toArray()
            ];
        }

        return [
            'step' => ''
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

    /**
     * Salva a rodada no banco de dados
     *
     * @return Round
     * @throws NonUniqueResultException
     */
    private function createRound(): Round
    {
        $result = $this
            ->entityManager
            ->getRepository(Round::class)
            ->findLastRoundNumber();

        $roundNumber = $result !== null ? $result->getRoundNumber() + 1 : 1;

        $round = new Round();
        $round->setName('Rodada ' . $roundNumber);
        $round->setRoundNumber($roundNumber);

        $this->entityManager->persist($round);
        $this->entityManager->flush();

        return $round;
    }

    /**
     * Rola o dado para saber qual personagem comeca o ataque
     *
     * @param Character $human
     * @param Character $orc
     * @return Character
     */
    private function initiative(Character $human, Character $orc): Character
    {
        $rpg = new RPG();
        $diceHuman = $rpg->rollDiceInitiative($human);
        $diceOrc = $rpg->rollDiceInitiative($orc);

        if ($diceHuman > $diceOrc) {
            return $human;
        } elseif ($diceHuman < $diceOrc) {
            return $orc;
        } else {
            return $this->initiative($human, $orc);
        }
    }
}
