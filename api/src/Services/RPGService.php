<?php

namespace App\Services;

use App\Entity\Character;
use App\Entity\Round;
use App\Entity\TurnRound;
use App\Enum\TurnStep;
use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use App\Model\RPG;
use App\Validation\TurnRequestValidation;
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
     * @var TurnRequestValidation
     */
    private $requestValidation;

    /**
     * RPGService constructor.
     * @param EntityManagerInterface $entityManager
     * @param TurnRequestValidation $requestValidation
     */
    public function __construct(EntityManagerInterface $entityManager, TurnRequestValidation $requestValidation)
    {
        $this->entityManager = $entityManager;
        $this->requestValidation = $requestValidation;
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
                'round'         => $round->toArray(),
                'characters'    => [
                    'human'     => $human !== null ? $human->toArray() : [],
                    'orc'       => $orc !== null ? $orc->toArray() : []
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
     * @throws ApiValidationException
     */
    public function startTurn(Request $request)
    {
        $content = $this->getContent($request);

        $this->requestValidation->validate($content);

        $step = $content['turn']['step'];
        $roundId = $content['round']['idRound'];

        switch ($step) {
            case TurnStep::INIATIVE:
                $characters = $content['round']['characters'];
                $human = $this->getCharacter($characters['human']['uniqueId']);
                $orc = $this->getCharacter($characters['orc']['uniqueId']);

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

                $this->createTurnRound(TurnStep::INIATIVE, $roundId, $characterStriker, $characterDefender);

                return [
                    'step' => TurnStep::ATTACK,
                    'character_striker'  => $characterStriker->toArray(),
                    'character_defender' => $characterDefender->toArray()
                ];

                break;

            case TurnStep::ATTACK:
                $characterStriker = $this->getCharacter($content['turn']['striker_uniqueId']);
                $characterDefender = $this->getCharacter($content['turn']['defender_uniqueId']);

                $rpg = new RPG();
                $attackStriker = $rpg->rollDiceAttack($characterStriker);
                $defenseDefender = $rpg->rollDiceDefender($characterDefender);

                if ($attackStriker > $defenseDefender) {
                    $damage = $rpg->calculateDamage($characterStriker);

                    $lifeDefender = $characterDefender->getAmountLife() - $damage;
                    $characterDefender->setAmountLife($lifeDefender);

                    if ($lifeDefender > 0) {
                        $this->createTurnRound(
                            TurnStep::ATTACK,
                            $roundId,
                            $characterStriker,
                            $characterDefender,
                            $damage
                        );

                        return $this->resultTurn(TurnStep::INIATIVE, $characterStriker, $characterDefender);
                    } else {
                        $this->createTurnRound(
                            TurnStep::TURN_FINISH,
                            $roundId,
                            $characterStriker,
                            $characterDefender,
                            $damage
                        );

                        return $this->resultTurn(TurnStep::TURN_FINISH, $characterStriker, $characterDefender);
                    }
                } else {
                    $this->createTurnRound(TurnStep::ATTACK, $roundId, $characterStriker, $characterDefender, 0);
                    return $this->resultTurn(TurnStep::INIATIVE, $characterStriker, $characterDefender);
                }
                break;

            default:
                $this->createTurnRound(TurnStep::INIATIVE, $roundId);
                return $this->resultTurn(TurnStep::INIATIVE);
        }
    }

    /**
     * Recupera os dados da requisicao
     *
     * @param Request $request
     * @return array
     */
    private function getContent(Request $request): array
    {
        return json_decode($request->getContent(), true);
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
     * Salva o turno no banco de dados
     *
     * @param string $type
     * @param integer $roundId
     * @param Character|null $characterStriker
     * @param Character|null $characterDefender
     * @param integer|null $damage
     * @return TurnRound
     */
    private function createTurnRound(
        string $type,
        int $roundId,
        ?Character $characterStriker = null,
        ?Character $characterDefender = null,
        ?int $damage = null
    ): TurnRound {
        $round = $this->entityManager->getRepository(Round::class)->find($roundId);
        $amountLifeStriker = $characterStriker !== null ? $characterStriker->getAmountLife() : null;
        $amountLifeDefender = $characterDefender !== null ? $characterDefender->getAmountLife() : null;

        $turnRound = new TurnRound();
        $turnRound
            ->setCharacterStriker($characterStriker)
            ->setCharacterDefender($characterDefender)
            ->setAmountLifeStriker($amountLifeStriker)
            ->setAmountLifeDefender($amountLifeDefender)
            ->setDamage($damage)
            ->setRound($round)
            ->setType($type);

        $this->entityManager->persist($turnRound);
        $this->entityManager->flush();

        return $turnRound;
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

    /**
     * Cria o resultado gerado no turno
     *
     * @param string $turnStep
     * @param Character|null $characterStriker
     * @param Character|null $characterDefender
     * @return array
     */
    private function resultTurn(
        string $turnStep,
        ?Character $characterStriker = null,
        ?Character $characterDefender = null
    ): array {
        return [
            'step' => $turnStep,
            'character_striker'  => $characterStriker !== null ? $characterStriker->toArray() : null,
            'character_defender' => $characterDefender !== null ? $characterDefender->toArray() : null
        ];
    }
}
