<?php

namespace App\Entity\Classes;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Construct\Skill;
use App\Entity\Construct\Table;
use App\Repository\Classes\SpecialtyItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialtyItemRepository::class)]
class SpecialtyItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Specialty>
     */
    #[ORM\ManyToMany(targetEntity: Specialty::class, inversedBy: 'items')]
    private Collection $specialty;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $part1 = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $part2 = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

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

    /**
     * @var Collection<int, Source>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, inversedBy: 'specialties')]
    private Collection $source;

    /**
     * @var Collection<int, SourcePart>
     */
    #[ORM\ManyToMany(targetEntity: SourcePart::class, inversedBy: 'specialties')]
    private Collection $source_part;

    /**
     * @var Collection<int, Table>
     */
    #[ORM\ManyToMany(targetEntity: Table::class, mappedBy: 'specialty_items')]
    private Collection $tables;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'specialty_items')]
    private Collection $skills;

    public function __construct()
    {
        $this->specialty = new ArrayCollection();
        $this->source = new ArrayCollection();
        $this->source_part = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Specialty>
     */
    public function getSpecialty(): Collection
    {
        return $this->specialty;
    }

    public function addSpecialty(Specialty $specialty): static
    {
        if (!$this->specialty->contains($specialty)) {
            $this->specialty->add($specialty);
        }

        return $this;
    }

    public function removeSpecialty(Specialty $specialty): static
    {
        $this->specialty->removeElement($specialty);

        return $this;
    }

    public function getPart1(): ?string
    {
        return $this->part1;
    }

    public function setPart1(?string $part1): static
    {
        $this->part1 = $part1;

        return $this;
    }

    public function getPart2(): ?string
    {
        return $this->part2;
    }

    public function setPart2(?string $part2): static
    {
        $this->part2 = $part2;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    /**
     * @return Collection<int, Source>
     */
    public function getSource(): Collection
    {
        return $this->source;
    }

    public function addSource(Source $source): static
    {
        if (!$this->source->contains($source)) {
            $this->source->add($source);
        }

        return $this;
    }

    public function removeSource(Source $source): static
    {
        $this->source->removeElement($source);

        return $this;
    }

    /**
     * @return Collection<int, SourcePart>
     */
    public function getSourcePart(): Collection
    {
        return $this->source_part;
    }

    public function addSourcePart(SourcePart $sourcePart): static
    {
        if (!$this->source_part->contains($sourcePart)) {
            $this->source_part->add($sourcePart);
        }

        return $this;
    }

    public function removeSourcePart(SourcePart $sourcePart): static
    {
        $this->source_part->removeElement($sourcePart);

        return $this;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->addSpecialtyItem($this);
        }

        return $this;
    }

    public function removeTable(Table $table): static
    {
        if ($this->tables->removeElement($table)) {
            $table->removeSpecialtyItem($this);
        }

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
            $skill->addSpecialtyItem($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeSpecialtyItem($this);
        }

        return $this;
    }
}
