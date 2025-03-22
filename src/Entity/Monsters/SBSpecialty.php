<?php

namespace App\Entity\Monsters;

use App\Repository\Monsters\SBSpecialtyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SBSpecialtyRepository::class)]
class SBSpecialty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'specialties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SB $monster = null;

    #[ORM\ManyToOne(inversedBy: 'specialties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SBSkill $skill = null;

    #[ORM\Column(length: 1000)]
    private ?string $d = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonster(): ?SB
    {
        return $this->monster;
    }

    public function setMonster(?SB $monster): static
    {
        $this->monster = $monster;

        return $this;
    }

    public function getSkill(): ?SBSkill
    {
        return $this->skill;
    }

    public function setSkill(?SBSkill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    public function getD(): ?string
    {
        return $this->d;
    }

    public function setD(string $d): static
    {
        $this->d = $d;

        return $this;
    }
}
