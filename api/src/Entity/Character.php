<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterRepository")
 * @ORM\Table(schema="public", name="characters")
 * @ORM\EntityListeners({"App\Listeners\CharacterListener"})
 */
class Character
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="amount_life")
     */
    private $amountLife;

    /**
     * @ORM\Column(type="integer", name="amount_strength")
     */
    private $amountStrength;

    /**
     * @ORM\Column(type="integer", name="amount_agility")
     */
    private $amountAgility;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CharacterWeapon", mappedBy="character", cascade={"persist", "remove"})
     */
    private $characterWeapon;

    /**
     * @ORM\Column(type="string", name="unique_id")
     */
    private $uniqueId;

    /**
     * @ORM\Column(type="integer", name="dice_faces")
     */
    private $diceFaces;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmountLife(): ?int
    {
        return $this->amountLife;
    }

    public function setAmountLife(int $amountLife): self
    {
        $this->amountLife = $amountLife;

        return $this;
    }

    public function getAmountStrength(): ?int
    {
        return $this->amountStrength;
    }

    public function setAmountStrength(int $amountStrength): self
    {
        $this->amountStrength = $amountStrength;

        return $this;
    }

    public function getAmountAgility(): ?int
    {
        return $this->amountAgility;
    }

    public function setAmountAgility(int $amountAgility): self
    {
        $this->amountAgility = $amountAgility;

        return $this;
    }

    public function getCharacterWeapon(): ?CharacterWeapon
    {
        return $this->characterWeapon;
    }

    public function setCharacterWeapon(CharacterWeapon $characterWeapon): self
    {
        $this->characterWeapon = $characterWeapon;

        // set the owning side of the relation if necessary
        if ($characterWeapon->getCharacter() !== $this) {
            $characterWeapon->setCharacter($this);
        }

        return $this;
    }

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * Transforma o objeto em um array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uniqueId'          => $this->uniqueId,
            'name'              => $this->name,
            'amountLife'        => $this->amountLife,
            'amountStrength'    => $this->amountStrength,
            'amountAgility'     => $this->amountAgility,
            'weapon'            => $this->getCharacterWeapon()->getWeapon()->toArray()
        ];
    }

    public function getDiceFaces(): ?int
    {
        return $this->diceFaces;
    }

    public function setDiceFaces(int $diceFaces): self
    {
        $this->diceFaces = $diceFaces;

        return $this;
    }
}
