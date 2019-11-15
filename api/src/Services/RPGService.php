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
 *
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
     *
     * @param EntityManagerInterface $entityManager
     * @param TurnRequestValidation  $requestValidation
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
                'round'      => $round->toArray(),
                'characters' => [
                    'human' => $human !== null ? $human->toArray() : [],
                    'orc'   => $orc !== null ? $orc->toArray() : [],
                ],
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
     * @throws ApiException
     * @throws NonUniqueResultException
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

                $turnRound = $this
                    ->createTurnRound(TurnStep::INIATIVE, $roundId, $characterStriker, $characterDefender);

                return $this->resultTurn(TurnStep::ATTACK, $turnRound);

            case TurnStep::ATTACK:
                $characterStriker = $this->getCharacter($content['turn']['striker_uniqueId']);
                $characterDefender = $this->getCharacter($content['turn']['defender_uniqueId']);

                $rpg = new RPG();
                $attackStriker = $rpg->rollDiceAttack($characterStriker);
                $defenseDefender = $rpg->rollDiceDefender($characterDefender);

                $lastRound = $this->getLastTurnRound($roundId);

                $amountLifeStriker = $this->getLastAmountLifeCharacter($characterStriker, $lastRound);
                $amountLifeDefender = $this->getLastAmountLifeCharacter($characterDefender, $lastRound);

                if ($attackStriker > $defenseDefender) {
                    $damage = $rpg->calculateDamage($characterStriker);

                    $lifeDefender = $amountLifeDefender - $damage;

                    if ($lifeDefender > 0) {
                        $turnRound = $this->createTurnRound(
                            TurnStep::ATTACK,
                            $roundId,
                            $characterStriker,
                            $characterDefender,
                            $amountLifeStriker,
                            $lifeDefender,
                            $damage
                        );

                        return $this->resultTurn(TurnStep::INIATIVE, $turnRound);
                    } else {
                        $turnRound = $this->createTurnRound(
                            TurnStep::TURN_FINISH,
                            $roundId,
                            $characterStriker,
                            $characterDefender,
                            $amountLifeStriker,
                            $lifeDefender,
                            $damage
                        );

                        return $this->resultTurn(TurnStep::TURN_FINISH, $turnRound);
                    }
                } else {
                    $turnRound = $this
                        ->createTurnRound(
                            TurnStep::ATTACK,
                            $roundId,
                            $characterStriker,
                            $characterDefender,
                            $amountLifeStriker,
                            $amountLifeDefender,
                            0
                        );

                    return $this->resultTurn(TurnStep::INIATIVE, $turnRound);
                }

            default:
                throw new ApiException('O step: {'.$step.'} informado não exite');
        }
    }

    /**
     * Recupera os dados da requisição
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
            ->findOneBy(
                [
                    'uniqueId' => $uniqueId,
                ]
            );

        return $characters;
    }

    /**
     * Recupera os dados do último turno do round
     *
     * @param integer $idRound
     * @return TurnRound|null
     * @throws NonUniqueResultException
     */
    private function getLastTurnRound(int $idRound): ?TurnRound
    {
        return $this
            ->entityManager
            ->getRepository(TurnRound::class)
            ->findLastTurnRoundWhereDamageNotNull($idRound);
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
        $round->setName('Rodada '.$roundNumber);
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
     * @param integer|null $amountLifeStriker
     * @param integer|null $amountLifeDefender
     * @param integer|null $damage
     * @return TurnRound
     */
    private function createTurnRound(
        string $type,
        int $roundId,
        ?Character $characterStriker = null,
        ?Character $characterDefender = null,
        ?int $amountLifeStriker = null,
        ?int $amountLifeDefender = null,
        ?int $damage = null
    ): TurnRound {
        $round = $this->entityManager->getRepository(Round::class)->find($roundId);

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
     * Rola o dado para saber qual personagem começa o ataque
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
     * @param string    $turnStep
     * @param TurnRound $turnRound
     * @return array
     */
    private function resultTurn(
        string $turnStep,
        TurnRound $turnRound
    ): array {
        $turnRounds = $this
            ->entityManager
            ->getRepository(TurnRound::class)
            ->findBy(['round' => $turnRound->getRound()->getId()], ['id' => 'desc']);

        $winner = null;

        if ($turnStep === TurnStep::TURN_FINISH) {
            $winner = $turnRound->getCharacterStriker()->toArray();
        }

        return [
            'nextStep'          => $turnStep,
            'strikerUniqueId'   => $turnRound->getCharacterStriker()->getUniqueId(),
            'defenderUniqueId'  => $turnRound->getCharacterDefender()->getUniqueId(),
            'winner'            => $winner,
            'turnRounds'        => array_map(function (TurnRound $turnRound) {
                return $turnRound->toArray();
            }, $turnRounds),
        ];
    }

    /**
     * Recupera o saldo da vida do personagem do último round
     *
     * @param Character $character
     * @param TurnRound $lastRound
     * @return integer
     */
    private function getLastAmountLifeCharacter(Character $character, ?TurnRound $lastRound): int
    {
        if ($lastRound === null) {
            return $character->getAmountLife();
        }

        if ($character->getUniqueId() === $lastRound->getCharacterStriker()->getUniqueId()) {
            return $lastRound->getAmountLifeStriker();
        } else {
            return $lastRound->getAmountLifeDefender();
        }
    }
}
