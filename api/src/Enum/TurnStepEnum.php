<?php

namespace App\Enum;

/**
 * Class TurnStepEnum
 * @package App\Enum
 */
abstract class TurnStepEnum
{
    const INIATIVE = "INIATIVE";
    const ATTACK = "ATTACK";
    const DAMAGE = "DAMAGE";
    const TURN_FINISH = "TURN_FINISH";
}
