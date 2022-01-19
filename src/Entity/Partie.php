<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]

class Partie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public int $id;

    public ?Score $scoreMax = null;

    #[ORM\OneToMany(mappedBy: "partie", targetEntity: Score::class, cascade: ['persist'])]
    #[ORM\OrderBy(['score' => 'DESC'])]
    public Collection|array $scores;

    public function __construct(
        #[ORM\Column(type:"date")]
        public ?\DateTime $date = null,

        #[ORM\ManyToOne(targetEntity: Jeu::class, inversedBy: "parties")]
        #[ORM\JoinColumn(nullable: false)]
        public ?Jeu $jeu = null,

    ) {
        $this->scores = new ArrayCollection();
        if ($date == null) {
            $this->date = new \DateTime();
        }
    }

    public function getResultat()
    {
        return implode("\n",
            array_map(
                fn (Score $s) => $s->joueur .':'. $s->score,
                $this->scores->toArray()
            )
        );
    }

    public function getScoreMax(): Score
    {
        ///** @var ?Score $max */
        //$max = null;
        //return array_reduce(
        //    $this->scores->toArray(),
        //    fn($m, Score $s) => max($m, $s->score??0),
        //    0
        //);

        if (!$this->scoreMax) {
            /** @var ?Score $max */
            $max = null;
            /** @var Score $score */
            foreach ($this->scores as $score) {
                if ($max == null || $score->score > $max->score) {
                    $max = $score;
                }
            }
            $this->scoreMax = $max;
        }
        return $this->scoreMax;
    }

    public function joueurs(): int
    {
        return $this->scores->count();
    }

    public function label(): ?string
    {
        if (!$this->getScoreMax()) return null;

        setlocale(LC_ALL, "fr_FR.UTF-8");
        $date = strftime("%e %b %Y", $this->date->getTimestamp());

        return
            $this->scoreMax->score
            . " ("
            .$this->scoreMax->joueur
            . " - "
            .$date
            . ")"
        ;
    }

}
