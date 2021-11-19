<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]

class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public int $id;

    public function __construct(
        #[ORM\Column(type:"string", length:255)]
        public string $nom,

        #[ORM\Column(type:"integer")]
        public int $joueursMin,

        #[ORM\Column(type:"integer")]
        public int $joueursMax,
    ) {}

}
