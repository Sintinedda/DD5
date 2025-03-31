<?php

namespace App\Entity\Classes;

use App\Entity\Assets\Competence;
use App\Entity\Construct\Subskill;
use App\Entity\Items\Item;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Spells\Spell;
use App\Repository\Classes\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\Column(length: 1000)]
    private ?string $d = null;

    #[ORM\Column]
    private ?int $dv = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'armorclasses')]
    #[ORM\JoinTable(name: '`classe_armor`')]
    private Collection $armor1;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'weaponclasses')]
    #[ORM\JoinTable(name: '`classe_weapon`')]
    private Collection $weapon1;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'toolclasses')]
    #[ORM\JoinTable(name: '`classe_tool`')]
    private Collection $tool1;

    #[ORM\Column]
    private array $save = [];

    /**
     * @var Collection<int, Competence>
     */
    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'classes')]
    private Collection $competences;

    #[ORM\Column(length: 500)]
    private ?string $equipment1 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $equipment2 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $equipment3 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $equipment4 = null;

    /**
     * @var Collection<int, ClasseLevel>
     */
    #[ORM\OneToMany(targetEntity: ClasseLevel::class, mappedBy: 'classe', orphanRemoval: true)]
    private Collection $levels;

    #[ORM\OneToOne(mappedBy: 'classe', cascade: ['persist', 'remove'])]
    private ?Specialty $specialty = null;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemSubcategory::class, inversedBy: 'armorclasses')]
    #[ORM\JoinTable(name: '`classe_armors`')]
    private Collection $armor2;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemSubcategory::class, inversedBy: 'weaponclasses')]
    #[ORM\JoinTable(name: '`classe_weapons`')]
    private Collection $weapon2;

    /**
     * @var Collection<int, Spell>
     */
    #[ORM\ManyToMany(targetEntity: Spell::class, mappedBy: 'classes')]
    private Collection $spells;

    /**
     * @var Collection<int, Spell>
     */
    #[ORM\ManyToMany(targetEntity: Spell::class, mappedBy: 'classes2')]
    private Collection $spells2;

    #[ORM\OneToOne(inversedBy: 'classe', cascade: ['persist', 'remove'])]
    private ?ClasseSpellcasting $spellcasting = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d2 = null;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemSubcategory::class, inversedBy: 'toolclasses')]
    #[ORM\JoinTable(name: '`classe_tools`')]
    private Collection $tool2;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gold = null;

    /**
     * @var Collection<int, Subskill>
     */
    #[ORM\OneToMany(targetEntity: Subskill::class, mappedBy: 'classe')]
    private Collection $subskills;

    #[ORM\Column]
    private ?bool $spell5 = null;

    #[ORM\Column]
    private ?bool $spell9 = null;

    #[ORM\Column]
    private ?bool $cantrip = null;

    #[ORM\Column]
    private ?bool $spell = null;

    #[ORM\Column]
    private ?bool $infusion = null;

    #[ORM\Column]
    private ?bool $rage = null;

    #[ORM\Column]
    private ?bool $martial = null;

    #[ORM\Column]
    private ?bool $sneak = null;

    #[ORM\Column]
    private ?bool $sorcery = null;

    #[ORM\Column]
    private ?bool $slot = null;

    #[ORM\Column]
    private ?bool $invocation = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $icon = null;

    public function __construct()
    {
        $this->armor1 = new ArrayCollection();
        $this->weapon1 = new ArrayCollection();
        $this->tool1 = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->levels = new ArrayCollection();
        $this->armor2 = new ArrayCollection();
        $this->weapon2 = new ArrayCollection();
        $this->spells = new ArrayCollection();
        $this->spells2 = new ArrayCollection();
        $this->tool2 = new ArrayCollection();
        $this->subskills = new ArrayCollection();
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

    public function getD(): ?string
    {
        return $this->d;
    }

    public function setD(string $d): static
    {
        $this->d = $d;

        return $this;
    }

    public function getDv(): ?int
    {
        return $this->dv;
    }

    public function setDv(int $dv): static
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getArmor1(): Collection
    {
        return $this->armor1;
    }

    public function addArmor1(Item $armor1): static
    {
        if (!$this->armor1->contains($armor1)) {
            $this->armor1->add($armor1);
        }

        return $this;
    }

    public function removeArmor1(Item $armor1): static
    {
        $this->armor1->removeElement($armor1);

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getWeapon1(): Collection
    {
        return $this->weapon1;
    }

    public function addWeapon1(Item $weapon1): static
    {
        if (!$this->weapon1->contains($weapon1)) {
            $this->weapon1->add($weapon1);
        }

        return $this;
    }

    public function removeWeapon1(Item $weapon1): static
    {
        $this->weapon1->removeElement($weapon1);

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getTool1(): Collection
    {
        return $this->tool1;
    }

    public function addTool1(Item $tool1): static
    {
        if (!$this->tool1->contains($tool1)) {
            $this->tool1->add($tool1);
        }

        return $this;
    }

    public function removeTool1(Item $tool1): static
    {
        $this->tool1->removeElement($tool1);

        return $this;
    }

    public function getSave(): array
    {
        return $this->save;
    }

    public function setSave(array $save): static
    {
        $this->save = $save;

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

    public function getEquipment1(): ?string
    {
        return $this->equipment1;
    }

    public function setEquipment1(string $equipment1): static
    {
        $this->equipment1 = $equipment1;

        return $this;
    }

    public function getEquipment2(): ?string
    {
        return $this->equipment2;
    }

    public function setEquipment2(?string $equipment2): static
    {
        $this->equipment2 = $equipment2;

        return $this;
    }

    public function getEquipment3(): ?string
    {
        return $this->equipment3;
    }

    public function setEquipment3(?string $equipment3): static
    {
        $this->equipment3 = $equipment3;

        return $this;
    }

    public function getEquipment4(): ?string
    {
        return $this->equipment4;
    }

    public function setEquipment4(?string $equipment4): static
    {
        $this->equipment4 = $equipment4;

        return $this;
    }

    /**
     * @return Collection<int, ClasseLevel>
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }

    public function addLevel(ClasseLevel $level): static
    {
        if (!$this->levels->contains($level)) {
            $this->levels->add($level);
            $level->setClasse($this);
        }

        return $this;
    }

    public function removeLevel(ClasseLevel $level): static
    {
        if ($this->levels->removeElement($level)) {
            // set the owning side to null (unless already changed)
            if ($level->getClasse() === $this) {
                $level->setClasse(null);
            }
        }

        return $this;
    }

    public function getSpecialty(): ?Specialty
    {
        return $this->specialty;
    }

    public function setSpecialty(?Specialty $specialty): static
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * @return Collection<int, ItemSubcategory>
     */
    public function getArmor2(): Collection
    {
        return $this->armor2;
    }

    public function addArmor2(ItemSubcategory $armor2): static
    {
        if (!$this->armor2->contains($armor2)) {
            $this->armor2->add($armor2);
        }

        return $this;
    }

    public function removeArmor2(ItemSubcategory $armor2): static
    {
        $this->armor2->removeElement($armor2);

        return $this;
    }

    /**
     * @return Collection<int, ItemSubcategory>
     */
    public function getWeapon2(): Collection
    {
        return $this->weapon2;
    }

    public function addWeapon2(ItemSubcategory $weapon2): static
    {
        if (!$this->weapon2->contains($weapon2)) {
            $this->weapon2->add($weapon2);
        }

        return $this;
    }

    public function removeWeapon2(ItemSubcategory $weapon2): static
    {
        $this->weapon2->removeElement($weapon2);

        return $this;
    }

    /**
     * @return Collection<int, Spell>
     */
    public function getSpells(): Collection
    {
        return $this->spells;
    }

    public function addSpell(Spell $spell): static
    {
        if (!$this->spells->contains($spell)) {
            $this->spells->add($spell);
            $spell->addClass($this);
        }

        return $this;
    }

    public function removeSpell(Spell $spell): static
    {
        if ($this->spells->removeElement($spell)) {
            $spell->removeClass($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Spell>
     */
    public function getSpells2(): Collection
    {
        return $this->spells2;
    }

    public function addSpells2(Spell $spells2): static
    {
        if (!$this->spells2->contains($spells2)) {
            $this->spells2->add($spells2);
            $spells2->addClasses2($this);
        }

        return $this;
    }

    public function removeSpells2(Spell $spells2): static
    {
        if ($this->spells2->removeElement($spells2)) {
            $spells2->removeClasses2($this);
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

    public function getD2(): ?string
    {
        return $this->d2;
    }

    public function setD2(?string $d2): static
    {
        $this->d2 = $d2;

        return $this;
    }

    /**
     * @return Collection<int, ItemSubcategory>
     */
    public function getTool2(): Collection
    {
        return $this->tool2;
    }

    public function addTool2(ItemSubcategory $tool2): static
    {
        if (!$this->tool2->contains($tool2)) {
            $this->tool2->add($tool2);
        }

        return $this;
    }

    public function removeTool2(ItemSubcategory $tool2): static
    {
        $this->tool2->removeElement($tool2);

        return $this;
    }

    public function getGold(): ?string
    {
        return $this->gold;
    }

    public function setGold(?string $gold): static
    {
        $this->gold = $gold;

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
            $subskill->setClasse($this);
        }

        return $this;
    }

    public function removeSubskill(Subskill $subskill): static
    {
        if ($this->subskills->removeElement($subskill)) {
            // set the owning side to null (unless already changed)
            if ($subskill->getClasse() === $this) {
                $subskill->setClasse(null);
            }
        }

        return $this;
    }

    public function isSpell5(): ?bool
    {
        return $this->spell5;
    }

    public function setSpell5(bool $spell5): static
    {
        $this->spell5 = $spell5;

        return $this;
    }

    public function isSpell9(): ?bool
    {
        return $this->spell9;
    }

    public function setSpell9(bool $spell9): static
    {
        $this->spell9 = $spell9;

        return $this;
    }

    public function isCantrip(): ?bool
    {
        return $this->cantrip;
    }

    public function setCantrip(bool $cantrip): static
    {
        $this->cantrip = $cantrip;

        return $this;
    }

    public function isSpell(): ?bool
    {
        return $this->spell;
    }

    public function setSpell(bool $spell): static
    {
        $this->spell = $spell;

        return $this;
    }

    public function isInfusion(): ?bool
    {
        return $this->infusion;
    }

    public function setInfusion(bool $infusion): static
    {
        $this->infusion = $infusion;

        return $this;
    }

    public function isRage(): ?bool
    {
        return $this->rage;
    }

    public function setRage(bool $rage): static
    {
        $this->rage = $rage;

        return $this;
    }

    public function isMartial(): ?bool
    {
        return $this->martial;
    }

    public function setMartial(bool $martial): static
    {
        $this->martial = $martial;

        return $this;
    }

    public function isSneak(): ?bool
    {
        return $this->sneak;
    }

    public function setSneak(bool $sneak): static
    {
        $this->sneak = $sneak;

        return $this;
    }

    public function isSorcery(): ?bool
    {
        return $this->sorcery;
    }

    public function setSorcery(bool $sorcery): static
    {
        $this->sorcery = $sorcery;

        return $this;
    }

    public function isSlot(): ?bool
    {
        return $this->slot;
    }

    public function setSlot(bool $slot): static
    {
        $this->slot = $slot;

        return $this;
    }

    public function isInvocation(): ?bool
    {
        return $this->invocation;
    }

    public function setInvocation(bool $invocation): static
    {
        $this->invocation = $invocation;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }
}
