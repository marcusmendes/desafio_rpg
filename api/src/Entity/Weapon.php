<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeaponRepository")
 * @ORM\Table(schema="public", name="weapons")
 * @ORM\EntityListeners({"App\Listeners\WeaponListener"})
 * @Schema(type="object", title="Weapon")
 */
class Weapon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="unique_id")
     * @Property(type="string", example="w_clava_de_madeira")
     */
    private $uniqueId;

    /**
     * @ORM\Column(type="string", length=100)
     * @Property(type="string", example="Espada Longa")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="amount_attack")
     * @Property(type="integer", example="2")
     */
    private $amountAttack;

    /**
     * @ORM\Column(type="integer", name="amount_defense")
     * @Property(type="integer", example="1")
     */
    private $amountDefense;

    /**
     * @ORM\Column(type="integer", name="amount_damage")
     * @Property(type="integer", example="3")
     */
    private $amountDamage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CharacterWeapon", mappedBy="weapon")
     */
    private $weaponsCharacter;

    public function __construct()
    {
        $this->weaponsCharacter = new ArrayCollection();
    }

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

    public function getAmountAttack(): ?int
    {
        return $this->amountAttack;
    }

    public function setAmountAttack(int $amountAttack): self
    {
        $this->amountAttack = $amountAttack;

        return $this;
    }

    public function getAmountDefense(): ?int
    {
        return $this->amountDefense;
    }

    public function setAmountDefense(int $amountDefense): self
    {
        $this->amountDefense = $amountDefense;

        return $this;
    }

    public function getAmountDamage(): ?int
    {
        return $this->amountDamage;
    }

    public function setAmountDamage(int $amountDamage): self
    {
        $this->amountDamage = $amountDamage;

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
     * @return Collection|CharacterWeapon[]
     */
    public function getWeaponsCharacter(): Collection
    {
        return $this->weaponsCharacter;
    }

    public function addWeaponsCharacter(CharacterWeapon $weaponsCharacter): self
    {
        if (!$this->weaponsCharacter->contains($weaponsCharacter)) {
            $this->weaponsCharacter[] = $weaponsCharacter;
            $weaponsCharacter->setWeapon($this);
        }

        return $this;
    }

    public function removeWeaponsCharacter(CharacterWeapon $weaponsCharacter): self
    {
        if ($this->weaponsCharacter->contains($weaponsCharacter)) {
            $this->weaponsCharacter->removeElement($weaponsCharacter);
            // set the owning side to null (unless already changed)
            if ($weaponsCharacter->getWeapon() === $this) {
                $weaponsCharacter->setWeapon(null);
            }
        }

        return $this;
    }

    /**
     * Transforma o objeto em array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uniqueId'      => $this->uniqueId,
            'name'          => $this->name,
            'amountAttack'  => $this->amountAttack,
            'amountDefense' => $this->amountDefense,
            'amountDamage'  => $this->amountDamage
        ];
    }
}
