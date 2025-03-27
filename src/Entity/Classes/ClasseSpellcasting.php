<?php

namespace App\Entity\Classes;

use App\Entity\Construct\Skill;
use App\Repository\Classes\ClasseSpellcastingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseSpellcastingRepository::class)]
class ClasseSpellcasting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $d = null;

    #[ORM\OneToOne(mappedBy: 'spellcasting', cascade: ['persist'])]
    private ?Classe $classe = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\OneToMany(targetEntity: Skill::class, mappedBy: 'spellcasting')]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        // unset the owning side of the relation if necessary
        if ($classe === null && $this->classe !== null) {
            $this->classe->setSpellcasting(null);
        }

        // set the owning side of the relation if necessary
        if ($classe !== null && $classe->getSpellcasting() !== $this) {
            $classe->setSpellcasting($this);
        }

        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setSpellcasting($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getSpellcasting() === $this) {
                $skill->setSpellcasting(null);
            }
        }

        return $this;
    }
}
