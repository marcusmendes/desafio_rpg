<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterWeaponRepository")
 * @ORM\Table(schema="public", name="character_weapon")
 */
class CharacterWeapon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Character", inversedBy="characterWeapon", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="id_character")
     */
    private $character;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Weapon", inversedBy="weaponsCharacter")
     * @ORM\JoinColumn(nullable=false, name="id_weapon")
     */
    private $weapon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    public function setCharacter(Character $character): self
    {
        $this->character = $character;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }
}
