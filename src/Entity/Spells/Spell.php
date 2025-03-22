<?php

namespace App\Entity\Spells;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\Classe;
use App\Repository\Spells\SpellRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpellRepository::class)]
class Spell
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $slug = null;

    #[ORM\Column(length: 20)]
    private ?string $name_fr = null;

    #[ORM\Column(length: 20)]
    private ?string $name_eng = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToOne(inversedBy: 'spells')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SpellSchool $school = null;

    #[ORM\Column]
    private ?bool $ritual = null;

    #[ORM\Column(length: 20)]
    private ?string $casting = null;

    #[ORM\Column(length: 20)]
    private ?string $range1 = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $range2 = null;

    #[ORM\Column]
    private array $components = [];

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $materials = null;

    #[ORM\Column(length: 50)]
    private ?string $duration = null;

    #[ORM\Column]
    private ?bool $concentration = null;

    #[ORM\Column(length: 500)]
    private ?string $short = null;

    #[ORM\Column(length: 1000)]
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

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $higher = null;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'spells')]
    private Collection $classes;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'spells2')]
    #[ORM\JoinTable(name: '`classe_spell_expanded`')]
    private Collection $classes2;

    #[ORM\ManyToOne(inversedBy: 'spells')]
    private ?Source $source = null;

    #[ORM\ManyToOne(inversedBy: 'spells')]
    private ?SourcePart $source_part = null;

    #[ORM\ManyToOne(inversedBy: 'spells')]
    private ?SpellListe $lists = null;

    #[ORM\ManyToOne(inversedBy: 'spells')]
    private ?SpellTable $tables = null;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->classes2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getNameFr(): ?string
    {
        return $this->name_fr;
    }

    public function setNameFr(string $name_fr): static
    {
        $this->name_fr = $name_fr;

        return $this;
    }

    public function getNameEng(): ?string
    {
        return $this->name_eng;
    }

    public function setNameEng(string $name_eng): static
    {
        $this->name_eng = $name_eng;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getSchool(): ?SpellSchool
    {
        return $this->school;
    }

    public function setSchool(?SpellSchool $school): static
    {
        $this->school = $school;

        return $this;
    }

    public function isRitual(): ?bool
    {
        return $this->ritual;
    }

    public function setRitual(bool $ritual): static
    {
        $this->ritual = $ritual;

        return $this;
    }

    public function getCasting(): ?string
    {
        return $this->casting;
    }

    public function setCasting(string $casting): static
    {
        $this->casting = $casting;

        return $this;
    }

    public function getRange1(): ?string
    {
        return $this->range1;
    }

    public function setRange1(string $range1): static
    {
        $this->range1 = $range1;

        return $this;
    }

    public function getRange2(): ?string
    {
        return $this->range2;
    }

    public function setRange2(?string $range2): static
    {
        $this->range2 = $range2;

        return $this;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function setComponents(array $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(?string $materials): static
    {
        $this->materials = $materials;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function isConcentration(): ?bool
    {
        return $this->concentration;
    }

    public function setConcentration(bool $concentration): static
    {
        $this->concentration = $concentration;

        return $this;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): static
    {
        $this->short = $short;

        return $this;
    }

    public function getD1(): ?string
    {
        return $this->d1;
    }

    public function setD1(string $d1): static
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

    public function getHigher(): ?string
    {
        return $this->higher;
    }

    public function setHigher(?string $higher): static
    {
        $this->higher = $higher;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
        }

        return $this;
    }

    public function removeClass(Classe $class): static
    {
        $this->classes->removeElement($class);

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses2(): Collection
    {
        return $this->classes2;
    }

    public function addClasses2(Classe $classes2): static
    {
        if (!$this->classes2->contains($classes2)) {
            $this->classes2->add($classes2);
        }

        return $this;
    }

    public function removeClasses2(Classe $classes2): static
    {
        $this->classes2->removeElement($classes2);

        return $this;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(?Source $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getSourcePart(): ?SourcePart
    {
        return $this->source_part;
    }

    public function setSourcePart(?SourcePart $source_part): static
    {
        $this->source_part = $source_part;

        return $this;
    }

    public function getLists(): ?SpellListe
    {
        return $this->lists;
    }

    public function setLists(?SpellListe $lists): static
    {
        $this->lists = $lists;

        return $this;
    }

    public function getTables(): ?SpellTable
    {
        return $this->tables;
    }

    public function setTables(?SpellTable $tables): static
    {
        $this->tables = $tables;

        return $this;
    }
}
