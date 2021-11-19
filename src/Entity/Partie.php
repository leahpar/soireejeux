<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]

class Partie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public int $id;

    public function __construct(
        #[ORM\Column(type:"date")]
        public \DateTimeImmutable $date,

        #[ORM\Column(type:"integer")]
        public int $nbJoueurs,
    ) {}

}
