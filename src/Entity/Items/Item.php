<?php

namespace App\Entity\Items;

use App\Entity\Assets\Damage;
use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Classes\Classe;
use App\Repository\Items\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'armor1')]
    private Collection $armorclasses;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'weapon1')]
    private Collection $weaponclasses;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'tool1')]
    private Collection $toolclasses;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?ItemSubcategory $subcategory = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ItemCategory $category = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $rarity = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $cost = null;

    #[ORM\Column(nullable: true)]
    private ?int $weight = null;

    #[ORM\Column(nullable: true)]
    private ?int $ca = null;

    #[ORM\Column]
    private ?bool $ca_dex = null;

    #[ORM\Column]
    private ?bool $ca_max = null;

    #[ORM\Column(nullable: true)]
    private ?int $ca_str = null;

    #[ORM\Column]
    private ?bool $ca_stealth = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ca_don = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ca_doff = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $dice = null;

    #[ORM\Column]
    private ?bool $link = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $damage = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Damage $damage2 = null;

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

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Source $source = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?SourcePart $source_part = null;

    /**
     * @var Collection<int, ItemTable>
     */
    #[ORM\ManyToMany(targetEntity: ItemTable::class, inversedBy: 'items')]
    private Collection $tables;

    /**
     * @var Collection<int, ItemProperty>
     */
    #[ORM\ManyToMany(targetEntity: ItemProperty::class, mappedBy: 'items')]
    private Collection $properties;

    public function __construct()
    {
        $this->armorclasses = new ArrayCollection();
        $this->weaponclasses = new ArrayCollection();
        $this->toolclasses = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getArmorClasses(): Collection
    {
        return $this->armorclasses;
    }

    public function addArmorClass(Classe $armorclass): static
    {
        if (!$this->armorclasses->contains($armorclass)) {
            $this->armorclasses->add($armorclass);
            $armorclass->addArmor1($this);
        }

        return $this;
    }

    public function removeArmorClass(Classe $armorclass): static
    {
        if ($this->armorclasses->removeElement($armorclass)) {
            $armorclass->removeArmor1($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getWeaponclasses(): Collection
    {
        return $this->weaponclasses;
    }

    public function addWeaponclass(Classe $weaponclass): static
    {
        if (!$this->weaponclasses->contains($weaponclass)) {
            $this->weaponclasses->add($weaponclass);
            $weaponclass->addWeapon1($this);
        }

        return $this;
    }

    public function removeWeaponclass(Classe $weaponclass): static
    {
        if ($this->weaponclasses->removeElement($weaponclass)) {
            $weaponclass->removeWeapon1($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getToolclasses(): Collection
    {
        return $this->toolclasses;
    }

    public function addToolclass(Classe $toolclass): static
    {
        if (!$this->toolclasses->contains($toolclass)) {
            $this->toolclasses->add($toolclass);
            $toolclass->addTool1($this);
        }

        return $this;
    }

    public function removeToolclass(Classe $toolclass): static
    {
        if ($this->toolclasses->removeElement($toolclass)) {
            $toolclass->removeTool1($this);
        }

        return $this;
    }

    public function getSubcategory(): ?ItemSubcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?ItemSubcategory $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    public function setCategory(?ItemCategory $category): static
    {
        $this->category = $category;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(?string $rarity): static
    {
        $this->rarity = $rarity;

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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

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

    public function isCaDex(): ?bool
    {
        return $this->ca_dex;
    }

    public function setCaDex(bool $ca_dex): static
    {
        $this->ca_dex = $ca_dex;

        return $this;
    }

    public function isCaMax(): ?bool
    {
        return $this->ca_max;
    }

    public function setCaMax(bool $ca_max): static
    {
        $this->ca_max = $ca_max;

        return $this;
    }

    public function getCaStr(): ?int
    {
        return $this->ca_str;
    }

    public function setCaStr(?int $ca_str): static
    {
        $this->ca_str = $ca_str;

        return $this;
    }

    public function isCaStealth(): ?bool
    {
        return $this->ca_stealth;
    }

    public function setCaStealth(bool $ca_stealth): static
    {
        $this->ca_stealth = $ca_stealth;

        return $this;
    }

    public function getCaDon(): ?string
    {
        return $this->ca_don;
    }

    public function setCaDon(?string $ca_don): static
    {
        $this->ca_don = $ca_don;

        return $this;
    }

    public function getCaDoff(): ?string
    {
        return $this->ca_doff;
    }

    public function setCaDoff(?string $ca_doff): static
    {
        $this->ca_doff = $ca_doff;

        return $this;
    }

    public function getDice(): ?string
    {
        return $this->dice;
    }

    public function setDice(?string $dice): static
    {
        $this->dice = $dice;

        return $this;
    }

    public function isLink(): ?bool
    {
        return $this->link;
    }

    public function setLink(bool $link): static
    {
        $this->link = $link;

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

    public function getDamage2(): ?Damage
    {
        return $this->damage2;
    }

    public function setDamage2(?Damage $damage2): static
    {
        $this->damage2 = $damage2;

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
     * @return Collection<int, ItemTable>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(ItemTable $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
        }

        return $this;
    }

    public function removeTable(ItemTable $table): static
    {
        $this->tables->removeElement($table);

        return $this;
    }

    /**
     * @return Collection<int, ItemProperty>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(ItemProperty $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->addItem($this);
        }

        return $this;
    }

    public function removeProperty(ItemProperty $property): static
    {
        if ($this->properties->removeElement($property)) {
            $property->removeItem($this);
        }

        return $this;
    }
}
