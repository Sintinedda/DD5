<?php

namespace App\Entity\Classes;

use App\Repository\Classes\ClasseSubskillRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseSubskillRepository::class)]
class ClasseSubskill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $t1 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d1 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d2 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d3 = null;

    #[ORM\ManyToOne(inversedBy: 'subskills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClasseSkill $skill = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getT1(): ?string
    {
        return $this->t1;
    }

    public function setT1(?string $t1): static
    {
        $this->t1 = $t1;

        return $this;
    }

    public function getD1(): ?string
    {
        return $this->d1;
    }

    public function setD1(?string $d1): static
    {
        $this->d1 = $d1;

        return $this;
    }

    public function getD2(): ?string
    {
        return $this->d2;
    }

    public function setD2(?string $d2): static
    {
        $this->d2 = $d2;

        return $this;
    }

    public function getD3(): ?string
    {
        return $this->d3;
    }

    public function setD3(?string $d3): static
    {
        $this->d3 = $d3;

        return $this;
    }

    public function getSkill(): ?ClasseSkill
    {
        return $this->skill;
    }

    public function setSkill(?ClasseSkill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }
}
