<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TurnRoundRepository")
 * @ORM\Table(schema="public", name="turn_rounds")
 */
class TurnRound
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Round", inversedBy="roundTurns")
     * @ORM\JoinColumn(nullable=false, name="id_round")
     */
    private $round;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Character")
     * @ORM\JoinColumn(nullable=false, name="id_character_striker")
     */
    private $characterStriker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Character")
     * @ORM\JoinColumn(nullable=false, name="id_character_defender")
     */
    private $characterDefender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true, name="amount_life_striker")
     */
    private $amountLifeStriker;

    /**
     * @ORM\Column(type="integer", nullable=true, name="amount_life_defender")
     */
    private $amountLifeDefender;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $damage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRound(): ?Round
    {
        return $this->round;
    }

    public function setRound(?Round $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getCharacterStriker(): ?Character
    {
        return $this->characterStriker;
    }

    public function setCharacterStriker(?Character $characterStriker): self
    {
        $this->characterStriker = $characterStriker;

        return $this;
    }

    public function getCharacterDefender(): ?Character
    {
        return $this->characterDefender;
    }

    public function setCharacterDefender(?Character $characterDefender): self
    {
        $this->characterDefender = $characterDefender;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAmountLifeStriker(): ?int
    {
        return $this->amountLifeStriker;
    }

    public function setAmountLifeStriker(?int $amountLifeStriker): self
    {
        $this->amountLifeStriker = $amountLifeStriker;

        return $this;
    }

    public function getAmountLifeDefender(): ?int
    {
        return $this->amountLifeDefender;
    }

    public function setAmountLifeDefender(?int $amountLifeDefender): self
    {
        $this->amountLifeDefender = $amountLifeDefender;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(?int $damage): self
    {
        $this->damage = $damage;

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
            'round'              => $this->getRound()->toArray(),
            'characterStriker'   => $this->getCharacterStriker()->toArray(),
            'characterDefender'  => $this->getCharacterDefender()->toArray(),
            'amountLifeStriker'  => $this->getAmountLifeStriker(),
            'amountLifeDefender' => $this->getAmountLifeDefender(),
            'damage'             => $this->getDamage(),
        ];
    }
}
