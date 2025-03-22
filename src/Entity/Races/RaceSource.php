<?php

namespace App\Entity\Races;

use App\Entity\Assets\Language;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Repository\Races\RaceSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceSourceRepository::class)]
class RaceSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Race $race = null;

    #[ORM\ManyToOne(inversedBy: 'races')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Source $source = null;

    #[ORM\ManyToOne(inversedBy: 'races')]
    private ?SourcePart $source_part = null;

    #[ORM\Column(length: 1000)]
    private ?string $d1 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d2 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ability = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $age = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $alignment = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $size = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $speed = null;

    /**
     * @var Collection<int, Language>
     */
    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'races')]
    private Collection $languages;

    /**
     * @var Collection<int, RaceSkill>
     */
    #[ORM\ManyToMany(targetEntity: RaceSkill::class, inversedBy: 'sources')]
    private Collection $skills;

    /**
     * @var Collection<int, RaceTable>
     */
    #[ORM\ManyToMany(targetEntity: RaceTable::class, inversedBy: 'sources')]
    private Collection $tables;

    /**
     * @var Collection<int, RaceSubrace>
     */
    #[ORM\OneToMany(targetEntity: RaceSubrace::class, mappedBy: 'source')]
    private Collection $subraces;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->subraces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

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

    public function getAbility(): ?string
    {
        return $this->ability;
    }

    public function setAbility(?string $ability): static
    {
        $this->ability = $ability;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    public function setAlignment(?string $alignment): static
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSpeed(): ?string
    {
        return $this->speed;
    }

    public function setSpeed(?string $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        $this->languages->removeElement($language);

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

    /**
     * @return Collection<int, RaceSubrace>
     */
    public function getSubraces(): Collection
    {
        return $this->subraces;
    }

    public function addSubrace(RaceSubrace $subrace): static
    {
        if (!$this->subraces->contains($subrace)) {
            $this->subraces->add($subrace);
            $subrace->setSource($this);
        }

        return $this;
    }

    public function removeSubrace(RaceSubrace $subrace): static
    {
        if ($this->subraces->removeElement($subrace)) {
            // set the owning side to null (unless already changed)
            if ($subrace->getSource() === $this) {
                $subrace->setSource(null);
            }
        }

        return $this;
    }
}
