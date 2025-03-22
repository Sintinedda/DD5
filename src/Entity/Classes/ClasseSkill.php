<?php

namespace App\Entity\Classes;

use App\Repository\Classes\ClasseSkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseSkillRepository::class)]
class ClasseSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $level = null;

    #[ORM\Column]
    private ?bool $show_skill = null;

    #[ORM\Column]
    private ?bool $optional = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d1 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d2 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d3 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d4 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d5 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d6 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d7 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d8 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d9 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d10 = null;

    /**
     * @var Collection<int, ClasseListe>
     */
    #[ORM\OneToMany(targetEntity: ClasseListe::class, mappedBy: 'skill')]
    private Collection $listes;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    private ?ClasseSpellcasting $spellcasting = null;

    /**
     * @var Collection<int, ClasseTable>
     */
    #[ORM\OneToMany(targetEntity: ClasseTable::class, mappedBy: 'skill')]
    private Collection $tables;

    /**
     * @var Collection<int, ClasseSubskill>
     */
    #[ORM\OneToMany(targetEntity: ClasseSubskill::class, mappedBy: 'skill', orphanRemoval: true)]
    private Collection $subskills;

    /**
     * @var Collection<int, ClasseLevel>
     */
    #[ORM\ManyToMany(targetEntity: ClasseLevel::class, mappedBy: 'skills')]
    private Collection $classeLevels;

    public function __construct()
    {
        $this->listes = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->subskills = new ArrayCollection();
        $this->classeLevels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function isShowSkill(): ?bool
    {
        return $this->show_skill;
    }

    public function setShowSkill(bool $show_skill): static
    {
        $this->show_skill = $show_skill;

        return $this;
    }

    public function isOptional(): ?bool
    {
        return $this->optional;
    }

    public function setOptional(bool $optional): static
    {
        $this->optional = $optional;

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

    public function getD4(): ?string
    {
        return $this->d4;
    }

    public function setD4(?string $d4): static
    {
        $this->d4 = $d4;

        return $this;
    }

    public function getD5(): ?string
    {
        return $this->d5;
    }

    public function setD5(?string $d5): static
    {
        $this->d5 = $d5;

        return $this;
    }

    public function getD6(): ?string
    {
        return $this->d6;
    }

    public function setD6(?string $d6): static
    {
        $this->d6 = $d6;

        return $this;
    }

    public function getD7(): ?string
    {
        return $this->d7;
    }

    public function setD7(?string $d7): static
    {
        $this->d7 = $d7;

        return $this;
    }

    public function getD8(): ?string
    {
        return $this->d8;
    }

    public function setD8(?string $d8): static
    {
        $this->d8 = $d8;

        return $this;
    }

    public function getD9(): ?string
    {
        return $this->d9;
    }

    public function setD9(?string $d9): static
    {
        $this->d9 = $d9;

        return $this;
    }

    public function getD10(): ?string
    {
        return $this->d10;
    }

    public function setD10(?string $d10): static
    {
        $this->d10 = $d10;

        return $this;
    }

    /**
     * @return Collection<int, ClasseListe>
     */
    public function getListes(): Collection
    {
        return $this->listes;
    }

    public function addListe(ClasseListe $liste): static
    {
        if (!$this->listes->contains($liste)) {
            $this->listes->add($liste);
            $liste->setSkill($this);
        }

        return $this;
    }

    public function removeListe(ClasseListe $liste): static
    {
        if ($this->listes->removeElement($liste)) {
            // set the owning side to null (unless already changed)
            if ($liste->getSkill() === $this) {
                $liste->setSkill(null);
            }
        }

        return $this;
    }

    public function getSpellcasting(): ?ClasseSpellcasting
    {
        return $this->spellcasting;
    }

    public function setSpellcasting(?ClasseSpellcasting $spellcasting): static
    {
        $this->spellcasting = $spellcasting;

        return $this;
    }

    /**
     * @return Collection<int, ClasseTable>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(ClasseTable $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->setSkill($this);
        }

        return $this;
    }

    public function removeTable(ClasseTable $table): static
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getSkill() === $this) {
                $table->setSkill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClasseSubskill>
     */
    public function getSubskills(): Collection
    {
        return $this->subskills;
    }

    public function addSubskill(ClasseSubskill $subskill): static
    {
        if (!$this->subskills->contains($subskill)) {
            $this->subskills->add($subskill);
            $subskill->setSkill($this);
        }

        return $this;
    }

    public function removeSubskill(ClasseSubskill $subskill): static
    {
        if ($this->subskills->removeElement($subskill)) {
            // set the owning side to null (unless already changed)
            if ($subskill->getSkill() === $this) {
                $subskill->setSkill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClasseLevel>
     */
    public function getClasseLevels(): Collection
    {
        return $this->classeLevels;
    }

    public function addClasseLevel(ClasseLevel $classeLevel): static
    {
        if (!$this->classeLevels->contains($classeLevel)) {
            $this->classeLevels->add($classeLevel);
            $classeLevel->addSkill($this);
        }

        return $this;
    }

    public function removeClasseLevel(ClasseLevel $classeLevel): static
    {
        if ($this->classeLevels->removeElement($classeLevel)) {
            $classeLevel->removeSkill($this);
        }

        return $this;
    }
}
