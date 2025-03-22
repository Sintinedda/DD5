<?php

namespace App\Entity\Classes;

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

    /**
     * @var Collection<int, ClasseSkill>
     */
    #[ORM\OneToMany(targetEntity: ClasseSkill::class, mappedBy: 'spellcasting')]
    private Collection $skills;

    #[ORM\Column(length: 10)]
    private ?string $modifier = null;

    #[ORM\OneToOne(mappedBy: 'spellcasting', cascade: ['persist'])]
    private ?ClasseLevel $classeLevel = null;

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

    /**
     * @return Collection<int, ClasseSkill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(ClasseSkill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setSpellcasting($this);
        }

        return $this;
    }

    public function removeSkill(ClasseSkill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getSpellcasting() === $this) {
                $skill->setSpellcasting(null);
            }
        }

        return $this;
    }

    public function getModifier(): ?string
    {
        return $this->modifier;
    }

    public function setModifier(string $modifier): static
    {
        $this->modifier = $modifier;

        return $this;
    }

    public function getClasseLevel(): ?ClasseLevel
    {
        return $this->classeLevel;
    }

    public function setClasseLevel(?ClasseLevel $classeLevel): static
    {
        // unset the owning side of the relation if necessary
        if ($classeLevel === null && $this->classeLevel !== null) {
            $this->classeLevel->setSpellcasting(null);
        }

        // set the owning side of the relation if necessary
        if ($classeLevel !== null && $classeLevel->getSpellcasting() !== $this) {
            $classeLevel->setSpellcasting($this);
        }

        $this->classeLevel = $classeLevel;

        return $this;
    }
}
