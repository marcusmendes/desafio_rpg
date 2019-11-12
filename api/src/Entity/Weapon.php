<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeaponRepository")
 * @ORM\Table(schema="public", name="weapons")
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
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="amount_attack")
     */
    private $amountAttack;

    /**
     * @ORM\Column(type="integer", name="amount_defense")
     */
    private $amountDefense;

    /**
     * @ORM\Column(type="integer", name="amount_damage")
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
            'id'            => $this->id,
            'name'          => $this->name,
            'amountAttack'  => $this->amountAttack,
            'amountDefense' => $this->amountDefense,
            'amountDamage'  => $this->amountDamage
        ];
    }
}
