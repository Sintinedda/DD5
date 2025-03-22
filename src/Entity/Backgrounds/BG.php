<?php

namespace App\Entity\Backgrounds;

use App\Entity\Assets\Competence;
use App\Entity\Assets\Language;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Repository\Backgrounds\BGRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BGRepository::class)]
class BG
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\ManyToOne(inversedBy: 'bGs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Source $source = null;

    #[ORM\ManyToOne(inversedBy: 'bGs')]
    private ?SourcePart $source_part = null;

    /**
     * @var Collection<int, Competence>
     */
    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'bGs')]
    private Collection $competences;

    /**
     * @var Collection<int, Language>
     */
    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'bGs')]
    private Collection $Language;

    #[ORM\Column(length: 1000)]
    private ?string $equipment = null;

    /**
     * @var Collection<int, BGSkill>
     */
    #[ORM\ManyToMany(targetEntity: BGSkill::class, inversedBy: 'bGs')]
    private Collection $skills;

    #[ORM\OneToOne(mappedBy: 'bg', cascade: ['persist', 'remove'])]
    private ?BGCarac $carac = null;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->Language = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): static
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguage(): Collection
    {
        return $this->Language;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->Language->contains($language)) {
            $this->Language->add($language);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        $this->Language->removeElement($language);

        return $this;
    }

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(string $equipment): static
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * @return Collection<int, BGSkill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(BGSkill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(BGSkill $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function getCarac(): ?BGCarac
    {
        return $this->carac;
    }

    public function setCarac(BGCarac $carac): static
    {
        // set the owning side of the relation if necessary
        if ($carac->getBg() !== $this) {
            $carac->setBg($this);
        }

        $this->carac = $carac;

        return $this;
    }
}
