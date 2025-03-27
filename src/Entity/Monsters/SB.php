<?php

namespace App\Entity\Monsters;

use App\Entity\Assets\Alignment;
use App\Entity\Assets\CreatureType;
use App\Entity\Assets\Sense;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Assets\Speed;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Monsters\SBSkill;
use App\Repository\Monsters\SBRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SBRepository::class)]
class SB
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_fr = null;

    #[ORM\Column(length: 50)]
    private ?string $name_eng = null;

    #[ORM\Column(length: 20)]
    private ?string $slug = null;

    #[ORM\Column(length: 20)]
    private ?string $category = null;

    #[ORM\ManyToOne(inversedBy: 'sBs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CreatureType $type = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type2 = null;

    #[ORM\Column]
    private array $sizes = [];

    #[ORM\Column]
    private ?bool $size_inf = null;

    #[ORM\Column]
    private ?bool $size_sup = null;

    #[ORM\Column(nullable: true)]
    private ?int $ca = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $armor = null;

    #[ORM\Column(nullable: true)]
    private ?int $pv = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $dv = null;

    #[ORM\Column]
    private ?int $strenght = null;

    #[ORM\Column]
    private ?int $dexterity = null;

    #[ORM\Column]
    private ?int $constitution = null;

    #[ORM\Column]
    private ?int $intelligence = null;

    #[ORM\Column]
    private ?int $wisdow = null;

    #[ORM\Column]
    private ?int $charisma = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $save = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $competence = null;

    /**
     * @var Collection<int, Sense>
     */
    #[ORM\ManyToMany(targetEntity: Sense::class, inversedBy: 'sBs')]
    private Collection $sens;

    #[ORM\Column(nullable: true)]
    private ?int $pp = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pp2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $fp = null;

    #[ORM\Column(nullable: true)]
    private ?int $xp = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $bm = null;

    #[ORM\Column(length: 800)]
    private ?string $d = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cac_t = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cac_r = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cac_d = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $range_t = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $range_r = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $range_d = null;

    #[ORM\ManyToOne(inversedBy: 'sBs')]
    private ?Source $source = null;

    #[ORM\ManyToOne(inversedBy: 'sBs')]
    private ?SourcePart $source_part = null;

    #[ORM\OneToOne(inversedBy: 'sB', cascade: ['persist'])]
    private ?SpecialtySkill $specialty = null;

    /**
     * @var Collection<int, SBSkill>
     */
    #[ORM\ManyToMany(targetEntity: SBSkill::class, mappedBy: 'monsters')]
    private Collection $skills;

    /**
     * @var Collection<int, SBSpecialty>
     */
    #[ORM\OneToMany(targetEntity: SBSpecialty::class, mappedBy: 'monster', orphanRemoval: true)]
    private Collection $specialties;

    #[ORM\ManyToOne(inversedBy: 'sBs')]
    private ?Alignment $alignment = null;

    /**
     * @var Collection<int, Speed>
     */
    #[ORM\ManyToMany(targetEntity: Speed::class, inversedBy: 'sBs')]
    private Collection $speeds;

    public function __construct()
    {
        $this->sens = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->specialties = new ArrayCollection();
        $this->speeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?CreatureType
    {
        return $this->type;
    }

    public function setType(?CreatureType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): static
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getSizes(): array
    {
        return $this->sizes;
    }

    public function setSizes(array $sizes): static
    {
        $this->sizes = $sizes;

        return $this;
    }

    public function isSizeInf(): ?bool
    {
        return $this->size_inf;
    }

    public function setSizeInf(bool $size_inf): static
    {
        $this->size_inf = $size_inf;

        return $this;
    }

    public function isSizeSup(): ?bool
    {
        return $this->size_sup;
    }

    public function setSizeSup(bool $size_sup): static
    {
        $this->size_sup = $size_sup;

        return $this;
    }

    public function getCa(): ?int
    {
        return $this->ca;
    }

    public function setCa(?int $ca): static
    {
        $this->ca = $ca;

        return $this;
    }

    public function getArmor(): ?string
    {
        return $this->armor;
    }

    public function setArmor(?string $armor): static
    {
        $this->armor = $armor;

        return $this;
    }

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(?int $pv): static
    {
        $this->pv = $pv;

        return $this;
    }

    public function getDv(): ?string
    {
        return $this->dv;
    }

    public function setDv(?string $dv): static
    {
        $this->dv = $dv;

        return $this;
    }

    public function getStrenght(): ?int
    {
        return $this->strenght;
    }

    public function setStrenght(int $strenght): static
    {
        $this->strenght = $strenght;

        return $this;
    }

    public function getDexterity(): ?int
    {
        return $this->dexterity;
    }

    public function setDexterity(int $dexterity): static
    {
        $this->dexterity = $dexterity;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): static
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): static
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getWisdow(): ?int
    {
        return $this->wisdow;
    }

    public function setWisdow(int $wisdow): static
    {
        $this->wisdow = $wisdow;

        return $this;
    }

    public function getCharisma(): ?int
    {
        return $this->charisma;
    }

    public function setCharisma(int $charisma): static
    {
        $this->charisma = $charisma;

        return $this;
    }

    public function getSave(): ?string
    {
        return $this->save;
    }

    public function setSave(?string $save): static
    {
        $this->save = $save;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(?string $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * @return Collection<int, Sense>
     */
    public function getSens(): Collection
    {
        return $this->sens;
    }

    public function addSen(Sense $sen): static
    {
        if (!$this->sens->contains($sen)) {
            $this->sens->add($sen);
        }

        return $this;
    }

    public function removeSen(Sense $sen): static
    {
        $this->sens->removeElement($sen);

        return $this;
    }

    public function getPp(): ?int
    {
        return $this->pp;
    }

    public function setPp(?int $pp): static
    {
        $this->pp = $pp;

        return $this;
    }

    public function getPp2(): ?string
    {
        return $this->pp2;
    }

    public function setPp2(?string $pp2): static
    {
        $this->pp2 = $pp2;

        return $this;
    }

    public function getFp(): ?float
    {
        return $this->fp;
    }

    public function setFp(?float $fp): static
    {
        $this->fp = $fp;

        return $this;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(?int $xp): static
    {
        $this->xp = $xp;

        return $this;
    }

    public function getBm(): ?string
    {
        return $this->bm;
    }

    public function setBm(?string $bm): static
    {
        $this->bm = $bm;

        return $this;
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

    public function getCacT(): ?string
    {
        return $this->cac_t;
    }

    public function setCacT(?string $cac_t): static
    {
        $this->cac_t = $cac_t;

        return $this;
    }

    public function getCacR(): ?string
    {
        return $this->cac_r;
    }

    public function setCacR(?string $cac_r): static
    {
        $this->cac_r = $cac_r;

        return $this;
    }

    public function getCacD(): ?string
    {
        return $this->cac_d;
    }

    public function setCacD(?string $cac_d): static
    {
        $this->cac_d = $cac_d;

        return $this;
    }

    public function getRangeT(): ?string
    {
        return $this->range_t;
    }

    public function setRangeT(?string $range_t): static
    {
        $this->range_t = $range_t;

        return $this;
    }

    public function getRangeR(): ?string
    {
        return $this->range_r;
    }

    public function setRangeR(?string $range_r): static
    {
        $this->range_r = $range_r;

        return $this;
    }

    public function getRangeD(): ?string
    {
        return $this->range_d;
    }

    public function setRangeD(?string $range_d): static
    {
        $this->range_d = $range_d;

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

    public function getSpecialty(): ?SpecialtySkill
    {
        return $this->specialty;
    }

    public function setSpecialty(?SpecialtySkill $specialty): static
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * @return Collection<int, SBSkill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(SBSkill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->addMonster($this);
        }

        return $this;
    }

    public function removeSkill(SBSkill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeMonster($this);
        }

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
            $specialty->setMonster($this);
        }

        return $this;
    }

    public function removeSpecialty(SBSpecialty $specialty): static
    {
        if ($this->specialties->removeElement($specialty)) {
            // set the owning side to null (unless already changed)
            if ($specialty->getMonster() === $this) {
                $specialty->setMonster(null);
            }
        }

        return $this;
    }

    public function getAlignment(): ?Alignment
    {
        return $this->alignment;
    }

    public function setAlignment(?Alignment $alignment): static
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * @return Collection<int, Speed>
     */
    public function getSpeeds(): Collection
    {
        return $this->speeds;
    }

    public function addSpeed(Speed $speed): static
    {
        if (!$this->speeds->contains($speed)) {
            $this->speeds->add($speed);
        }

        return $this;
    }

    public function removeSpeed(Speed $speed): static
    {
        $this->speeds->removeElement($speed);

        return $this;
    }
}
