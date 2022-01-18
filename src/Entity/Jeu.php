<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]

class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public int $id;

    public ?Partie $partieMax = null;

    #[ORM\OneToMany(mappedBy: "jeu", targetEntity: Partie::class, cascade: ['persist'])]
    #[ORM\OrderBy(["date" => "DESC"])]
    public Collection|array $parties;

    public function __construct(
        #[ORM\Column(type:"string", length:255)]
        public ?string $nom = null,

        #[ORM\Column(type:"string", length:255, nullable: true)]
        public ?string $variante = null,

        #[ORM\Column(type:"integer")]
        public ?int $joueursMin = null,

        #[ORM\Column(type:"integer")]
        public ?int $joueursMax = null,
    ) {}

    public function getNbParties()
    {
        return count($this->parties);
    }

    public function __toString(): string
    {
        return implode(' - ', array_filter([
            $this->nom, $this->variante
        ], 'strlen'));
    }

    public function dernierePartie(): ?\DateTime
    {
        return $this->parties[0]?->date;
    }

    public function getScoreMax(): ?Partie
    {
        //$score = array_reduce(
        //    $this->parties->toArray(),
        //    fn($m, Partie $p) => max($m, $p->getScoreMax()->score),
        //    0
        //);

        if (!$this->partieMax) {
            $max = null;
            /** @var Partie $partie */
            foreach ($this->parties as $partie) {
                if ($max == null || $partie->getScoreMax()->score > $max->getScoreMax()->score) {
                    $max = $partie;
                }
            }
            $this->partieMax = $max;
        }

        return $this->partieMax;
    }

}
