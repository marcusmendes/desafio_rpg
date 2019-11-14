<?php

namespace App\Listeners;

use App\Entity\Character;
use App\Exceptions\ApiException;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class CharacterListener
 * @package App\Listeners
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/events.html#entity-listeners
 */
class CharacterListener
{
    /**
     * @ORM\PrePersist()
     *
     * @param Character $character
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(Character $character, LifecycleEventArgs $event)
    {
        $uniqueId = sprintf("c_%s", str_replace(' ', '_', strtolower($character->getName())));
        $character->setUniqueId($uniqueId);
    }
}
