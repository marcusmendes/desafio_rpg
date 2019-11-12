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
}
