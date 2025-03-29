<?php

namespace App\Entity\Construct;

use App\Entity\Assets\Feat;
use App\Entity\Backgrounds\BG;
use App\Entity\Classes\ClasseLevel;
use App\Entity\Classes\ClasseSpellcasting;
use App\Entity\Classes\SpecialtyItem;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Monsters\SB;
use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceSubrace;
use App\Repository\Construct\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
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
     * @var Collection<int, Liste>
     */
    #[ORM\OneToMany(targetEntity: Liste::class, mappedBy: 'skill')]
    private Collection $listes;

    /**
     * @var Collection<int, Table>
     */
    #[ORM\OneToMany(targetEntity: Table::class, mappedBy: 'skill')]
    private Collection $tables;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $part = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $attack_type = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $damage = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $target = null;

    /**
     * @var Collection<int, BG>
     */
    #[ORM\ManyToMany(targetEntity: BG::class, inversedBy: 'skills')]
    private Collection $bgs;

    /**
     * @var Collection<int, ItemCategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemCategory::class, inversedBy: 'skills')]
    private Collection $item_categories;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemSubcategory::class, inversedBy: 'skills')]
    private Collection $item_subcategories;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    private ?ClasseSpellcasting $spellcasting = null;

    /**
     * @var Collection<int, Subskill>
     */
    #[ORM\OneToMany(targetEntity: Subskill::class, mappedBy: 'skill')]
    private Collection $subskills;

    /**
     * @var Collection<int, ClasseLevel>
     */
    #[ORM\ManyToMany(targetEntity: ClasseLevel::class, inversedBy: 'skills')]
    private Collection $classe_levels;

    /**
     * @var Collection<int, SpecialtyItem>
     */
    #[ORM\ManyToMany(targetEntity: SpecialtyItem::class, inversedBy: 'skills')]
    private Collection $specialty_items;

    #[ORM\OneToOne(inversedBy: 'skill', cascade: ['persist', 'remove'])]
    private ?SB $monster = null;

    /**
     * @var Collection<int, RaceSource>
     */
    #[ORM\ManyToMany(targetEntity: RaceSource::class, inversedBy: 'skills')]
    private Collection $race_source;

    /**
     * @var Collection<int, RaceSubrace>
     */
    #[ORM\ManyToMany(targetEntity: RaceSubrace::class, inversedBy: 'skills')]
    private Collection $race_subrace;

    public function __construct()
    {
        $this->listes = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->bgs = new ArrayCollection();
        $this->item_categories = new ArrayCollection();
        $this->item_subcategories = new ArrayCollection();
        $this->subskills = new ArrayCollection();
        $this->classe_levels = new ArrayCollection();
        $this->specialty_items = new ArrayCollection();
        $this->race_source = new ArrayCollection();
        $this->race_subrace = new ArrayCollection();
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
     * @return Collection<int, Liste>
     */
    public function getListes(): Collection
    {
        return $this->listes;
    }

    public function addListe(Liste $liste): static
    {
        if (!$this->listes->contains($liste)) {
            $this->listes->add($liste);
            $liste->setSkill($this);
        }

        return $this;
    }

    public function removeListe(Liste $liste): static
    {
        if ($this->listes->removeElement($liste)) {
            // set the owning side to null (unless already changed)
            if ($liste->getSkill() === $this) {
                $liste->setSkill(null);
            }
        }

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
            $table->setSkill($this);
        }

        return $this;
    }

    public function removeTable(Table $table): static
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getSkill() === $this) {
                $table->setSkill(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

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

    public function getAttackType(): ?string
    {
        return $this->attack_type;
    }

    public function setAttackType(?string $attack_type): static
    {
        $this->attack_type = $attack_type;

        return $this;
    }

    public function getDamage(): ?string
    {
        return $this->damage;
    }

    public function setDamage(?string $damage): static
    {
        $this->damage = $damage;

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
     * @return Collection<int, BG>
     */
    public function getBgs(): Collection
    {
        return $this->bgs;
    }

    public function addBg(BG $bg): static
    {
        if (!$this->bgs->contains($bg)) {
            $this->bgs->add($bg);
        }

        return $this;
    }

    public function removeBg(BG $bg): static
    {
        $this->bgs->removeElement($bg);

        return $this;
    }

    /**
     * @return Collection<int, ItemCategory>
     */
    public function getItemCategories(): Collection
    {
        return $this->item_categories;
    }

    public function addItemCategory(ItemCategory $itemCategory): static
    {
        if (!$this->item_categories->contains($itemCategory)) {
            $this->item_categories->add($itemCategory);
        }

        return $this;
    }

    public function removeItemCategory(ItemCategory $itemCategory): static
    {
        $this->item_categories->removeElement($itemCategory);

        return $this;
    }

    /**
     * @return Collection<int, ItemSubcategory>
     */
    public function getItemSubcategories(): Collection
    {
        return $this->item_subcategories;
    }

    public function addItemSubcategory(ItemSubcategory $itemSubcategory): static
    {
        if (!$this->item_subcategories->contains($itemSubcategory)) {
            $this->item_subcategories->add($itemSubcategory);
        }

        return $this;
    }

    public function removeItemSubcategory(ItemSubcategory $itemSubcategory): static
    {
        $this->item_subcategories->removeElement($itemSubcategory);

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
     * @return Collection<int, Subskill>
     */
    public function getSubskills(): Collection
    {
        return $this->subskills;
    }

    public function addSubskill(Subskill $subskill): static
    {
        if (!$this->subskills->contains($subskill)) {
            $this->subskills->add($subskill);
            $subskill->setSkill($this);
        }

        return $this;
    }

    public function removeSubskill(Subskill $subskill): static
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
        return $this->classe_levels;
    }

    public function addClasseLevel(ClasseLevel $classeLevel): static
    {
        if (!$this->classe_levels->contains($classeLevel)) {
            $this->classe_levels->add($classeLevel);
        }

        return $this;
    }

    public function removeClasseLevel(ClasseLevel $classeLevel): static
    {
        $this->classe_levels->removeElement($classeLevel);

        return $this;
    }

    /**
     * @return Collection<int, SpecialtyItem>
     */
    public function getSpecialtyItems(): Collection
    {
        return $this->specialty_items;
    }

    public function addSpecialtyItem(SpecialtyItem $specialtyItem): static
    {
        if (!$this->specialty_items->contains($specialtyItem)) {
            $this->specialty_items->add($specialtyItem);
        }

        return $this;
    }

    public function removeSpecialtyItem(SpecialtyItem $specialtyItem): static
    {
        $this->specialty_items->removeElement($specialtyItem);

        return $this;
    }

    public function getMonster(): ?SB
    {
        return $this->monster;
    }

    public function setMonster(?SB $monster): static
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * @return Collection<int, RaceSource>
     */
    public function getRaceSource(): Collection
    {
        return $this->race_source;
    }

    public function addRaceSource(RaceSource $raceSource): static
    {
        if (!$this->race_source->contains($raceSource)) {
            $this->race_source->add($raceSource);
        }

        return $this;
    }

    public function removeRaceSource(RaceSource $raceSource): static
    {
        $this->race_source->removeElement($raceSource);

        return $this;
    }

    /**
     * @return Collection<int, RaceSubrace>
     */
    public function getRaceSubrace(): Collection
    {
        return $this->race_subrace;
    }

    public function addRaceSubrace(RaceSubrace $raceSubrace): static
    {
        if (!$this->race_subrace->contains($raceSubrace)) {
            $this->race_subrace->add($raceSubrace);
        }

        return $this;
    }

    public function removeRaceSubrace(RaceSubrace $raceSubrace): static
    {
        $this->race_subrace->removeElement($raceSubrace);

        return $this;
    }
}
