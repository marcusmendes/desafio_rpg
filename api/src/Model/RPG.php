<?php

namespace App\Model;

use App\Entity\Character;

/**
 * Class RPG
 * @package App\Model
 */
class RPG
{
    const DICE_INITIATIVE_FACES = 20;

    /**
     * Rola o dado para saber quem inicia o ataque
     *
     * @param Character $character
     * @return integer
     */
    public function rollDiceInitiative(Character $character): int
    {
        $rollDice = rand(1, self::DICE_INITIATIVE_FACES);
        return $character->getAmountAgility() + $rollDice;
    }

    /**
     * Rola o dado para calcular o dano do atacante
     *
     * @param Character $character
     * @return integer
     */
    public function rollDiceAttack(Character $character): int
    {
        $rollDice = rand(1, self::DICE_INITIATIVE_FACES);
        $agility = $character->getAmountAgility();
        $weaponAmountAttack = $character->getCharacterWeapon()->getWeapon()->getAmountAttack();

        return $rollDice + $agility + $weaponAmountAttack;
    }

    /**
     * Rola o dado para calcular a defesa do defensor
     *
     * @param Character $character
     * @return integer
     */
    public function rollDiceDefender(Character $character): int
    {
        $rollDice = rand(1, self::DICE_INITIATIVE_FACES);
        $agility = $character->getAmountAgility();
        $weaponAmountDefense = $character->getCharacterWeapon()->getWeapon()->getAmountDefense();

        return $rollDice + $agility + $weaponAmountDefense;
    }

    /**
     * Calcula o dano
     *
     * @param Character $character
     * @return integer
     */
    public function calculateDamage(Character $character): int
    {
        $rollDice = rand(1, $character->getDiceFaces());
        return $rollDice + $character->getAmountStrength();
    }
}
