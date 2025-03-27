<?php

namespace App\Entity\Items;

use App\Entity\Classes\Classe;
use App\Entity\Construct\Liste;
use App\Entity\Construct\Skill;
use App\Entity\Construct\Table;
use App\Entity\Items\ItemCategory;
use App\Repository\Items\ItemSubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemSubcategoryRepository::class)]
class ItemSubcategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subcategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ItemCategory $category = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $place = null;

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
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'armor2')]
    private Collection $armorclasses;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'weapon2')]
    private Collection $weaponclasses;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'subcategory')]
    private Collection $items;

    /**
     * @var Collection<int, Liste>
     */
    #[ORM\ManyToMany(targetEntity: Liste::class, mappedBy: 'item_subcategories')]
    private Collection $listes;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'item_subcategories')]
    private Collection $skills;

    /**
     * @var Collection<int, Table>
     */
    #[ORM\ManyToMany(targetEntity: Table::class, mappedBy: 'item_subcategories')]
    private Collection $tables;

    public function __construct()
    {
        $this->armorclasses = new ArrayCollection();
        $this->weaponclasses = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->listes = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->tables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setName(?string $name): static
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

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): static
    {
        $this->place = $place;

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
     * @return Collection<int, Classe>
     */
    public function getArmorclasses(): Collection
    {
        return $this->armorclasses;
    }

    public function addArmorclass(Classe $armorclass): static
    {
        if (!$this->armorclasses->contains($armorclass)) {
            $this->armorclasses->add($armorclass);
            $armorclass->addArmor2($this);
        }

        return $this;
    }

    public function removeArmorclass(Classe $armorclass): static
    {
        if ($this->armorclasses->removeElement($armorclass)) {
            $armorclass->removeArmor2($this);
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
            $weaponclass->addWeapon2($this);
        }

        return $this;
    }

    public function removeWeaponclass(Classe $weaponclass): static
    {
        if ($this->weaponclasses->removeElement($weaponclass)) {
            $weaponclass->removeWeapon2($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSubcategory($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSubcategory() === $this) {
                $item->setSubcategory(null);
            }
        }

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
            $liste->addItemSubcategory($this);
        }

        return $this;
    }

    public function removeListe(Liste $liste): static
    {
        if ($this->listes->removeElement($liste)) {
            $liste->removeItemSubcategory($this);
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
            $skill->addItemSubcategory($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeItemSubcategory($this);
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
            $table->addItemSubcategory($this);
        }

        return $this;
    }

    public function removeTable(Table $table): static
    {
        if ($this->tables->removeElement($table)) {
            $table->removeItemSubcategory($this);
        }

        return $this;
    }
}
