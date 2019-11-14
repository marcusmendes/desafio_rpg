<?php

namespace App\Listeners;

use App\Entity\Weapon;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WeaponListener
 * @package App\Listeners
 */
class WeaponListener
{
    /**
     * @ORM\PrePersist()
     *
     * @param Weapon $weapon
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(Weapon $weapon, LifecycleEventArgs $event)
    {
        $uniqueId = sprintf("w_%s", str_replace(' ', '_', strtolower($weapon->getName())));
        $weapon->setUniqueId($uniqueId);
    }
}
