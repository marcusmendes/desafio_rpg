<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoundRepository")
 * @ORM\Table(schema="public", name="rounds")
 */
class Round
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="round_number")
     */
    private $roundNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TurnRound", mappedBy="round")
     */
    private $roundTurns;

    public function __construct()
    {
        $this->roundTurns = new ArrayCollection();
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

    public function getRoundNumber(): ?int
    {
        return $this->roundNumber;
    }

    public function setRoundNumber(int $roundNumber): self
    {
        $this->roundNumber = $roundNumber;

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
            'id' => $this->id,
            'name' => $this->name,
            'roundNumber' => $this->roundNumber
        ];
    }

    /**
     * @return Collection|TurnRound[]
     */
    public function getRoundTurns(): Collection
    {
        return $this->roundTurns;
    }

    public function addRoundTurn(TurnRound $roundTurn): self
    {
        if (!$this->roundTurns->contains($roundTurn)) {
            $this->roundTurns[] = $roundTurn;
            $roundTurn->setRound($this);
        }

        return $this;
    }

    public function removeRoundTurn(TurnRound $roundTurn): self
    {
        if ($this->roundTurns->contains($roundTurn)) {
            $this->roundTurns->removeElement($roundTurn);
            // set the owning side to null (unless already changed)
            if ($roundTurn->getRound() === $this) {
                $roundTurn->setRound(null);
            }
        }

        return $this;
    }
}
