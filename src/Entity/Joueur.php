<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]

class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public int $id;

    #[ORM\OneToMany(mappedBy: "joueur", targetEntity: Score::class, cascade: ['persist'])]
    public Collection $scores;

    public function __construct(
        #[ORM\Column(type:"string", length:255)]
        public ?string $nom = null,
    ) {}

    public function __toString(): string
    {
        return $this->nom;
    }

}
