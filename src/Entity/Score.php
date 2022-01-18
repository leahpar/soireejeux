<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]

class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public int $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Joueur::class, inversedBy: "scores")]
        #[ORM\JoinColumn(nullable: false)]
        public ?Joueur $joueur = null,

        #[ORM\ManyToOne(targetEntity: Partie::class, inversedBy: "scores")]
        #[ORM\JoinColumn(nullable: false)]
        public ?Partie $partie = null,

        #[ORM\Column(type:"integer")]
        public ?int $score = null,
    ) {}

    public function __toString(): string
    {
        return
            "{"
            . $this->joueur?->nom
            . ':'
            . $this->score
            . "}"
            ;
    }


}
