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
     * @throws ApiException
     */
    public function prePersistHandler(Character $character, LifecycleEventArgs $event)
    {
        try {
            $lastUniqueId = $event
                ->getEntityManager()
                ->getRepository(Character::class)
                ->findLastUniqueId();

            if ($lastUniqueId !== null) {
                $character->setUniqueId($lastUniqueId->getUniqueId() + 1);
            } else {
                $character->setUniqueId(1000);
            }
        } catch (NonUniqueResultException $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
