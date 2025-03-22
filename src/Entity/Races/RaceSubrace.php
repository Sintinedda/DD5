<?php

namespace App\Entity\Races;

use App\Repository\Races\RaceSubraceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceSubraceRepository::class)]
class RaceSubrace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subraces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RaceSource $source = null;

    #[ORM\Column(length: 20)]
    private ?string $slug = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d1 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d2 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d3 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $ability = null;

    /**
     * @var Collection<int, RaceSkill>
     */
    #[ORM\ManyToMany(targetEntity: RaceSkill::class, inversedBy: 'subraces')]
    private Collection $skills;

    /**
     * @var Collection<int, RaceTable>
     */
    #[ORM\ManyToMany(targetEntity: RaceTable::class, inversedBy: 'subraces')]
    private Collection $tables;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->tables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?RaceSource
    {
        return $this->source;
    }

    public function setSource(?RaceSource $source): static
    {
        $this->source = $source;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getAbility(): ?string
    {
        return $this->ability;
    }

    public function setAbility(?string $ability): static
    {
        $this->ability = $ability;

        return $this;
    }

    /**
     * @return Collection<int, RaceSkill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(RaceSkill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(RaceSkill $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    /**
     * @return Collection<int, RaceTable>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(RaceTable $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
        }

        return $this;
    }

    public function removeTable(RaceTable $table): static
    {
        $this->tables->removeElement($table);

        return $this;
    }
}
