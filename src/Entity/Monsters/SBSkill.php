<?php

namespace App\Entity\Monsters;

use App\Entity\Assets\Damage;
use App\Repository\Monsters\SBSkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SBSkillRepository::class)]
class SBSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, SB>
     */
    #[ORM\ManyToMany(targetEntity: SB::class, inversedBy: 'skills')]
    private Collection $monsters;

    #[ORM\Column(length: 10)]
    private ?string $type = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $part = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $type_attack = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $target = null;

    /**
     * @var Collection<int, SBSpecialty>
     */
    #[ORM\OneToMany(targetEntity: SBSpecialty::class, mappedBy: 'skill', orphanRemoval: true)]
    private Collection $specialties;

    #[ORM\ManyToOne(inversedBy: 'sBSkills')]
    private ?Damage $damage = null;

    public function __construct()
    {
        $this->monsters = new ArrayCollection();
        $this->specialties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, SB>
     */
    public function getMonsters(): Collection
    {
        return $this->monsters;
    }

    public function addMonster(SB $monster): static
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters->add($monster);
        }

        return $this;
    }

    public function removeMonster(SB $monster): static
    {
        $this->monsters->removeElement($monster);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPart(): ?string
    {
        return $this->part;
    }

    public function setPart(?string $part): static
    {
        $this->part = $part;

        return $this;
    }

    public function getD(): ?string
    {
        return $this->d;
    }

    public function setD(?string $d): static
    {
        $this->d = $d;

        return $this;
    }

    public function getTypeAttack(): ?string
    {
        return $this->type_attack;
    }

    public function setTypeAttack(?string $type_attack): static
    {
        $this->type_attack = $type_attack;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return Collection<int, SBSpecialty>
     */
    public function getSpecialties(): Collection
    {
        return $this->specialties;
    }

    public function addSpecialty(SBSpecialty $specialty): static
    {
        if (!$this->specialties->contains($specialty)) {
            $this->specialties->add($specialty);
            $specialty->setSkill($this);
        }

        return $this;
    }

    public function removeSpecialty(SBSpecialty $specialty): static
    {
        if ($this->specialties->removeElement($specialty)) {
            // set the owning side to null (unless already changed)
            if ($specialty->getSkill() === $this) {
                $specialty->setSkill(null);
            }
        }

        return $this;
    }

    public function getDamage(): ?Damage
    {
        return $this->damage;
    }

    public function setDamage(?Damage $damage): static
    {
        $this->damage = $damage;

        return $this;
    }
}
