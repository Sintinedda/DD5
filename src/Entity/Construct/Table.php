<?php

namespace App\Entity\Construct;

use App\Entity\Backgrounds\BGCarac;
use App\Entity\Classes\SpecialtyItem;
use App\Entity\Items\Item;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Spells\Spell;
use App\Repository\Construct\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?int $place = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    private ?Skill $skill = null;

    /**
     * @var Collection<int, TableRow>
     */
    #[ORM\OneToMany(targetEntity: TableRow::class, mappedBy: 'tableau', orphanRemoval: true)]
    private Collection $rows;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    private ?BGCarac $bg_carac = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'tables')]
    private Collection $items;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemSubcategory::class, inversedBy: 'tables')]
    private Collection $item_subcategories;

    /**
     * @var Collection<int, SpecialtyItem>
     */
    #[ORM\ManyToMany(targetEntity: SpecialtyItem::class, inversedBy: 'tables')]
    private Collection $specialty_items;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    private ?Spell $spell = null;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->item_subcategories = new ArrayCollection();
        $this->specialty_items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, TableRow>
     */
    public function getTableRows(): Collection
    {
        return $this->rows;
    }

    public function addTableRow(TableRow $row): static
    {
        if (!$this->rows->contains($row)) {
            $this->rows->add($row);
            $row->setTableau($this);
        }

        return $this;
    }

    public function removeTableRow(TableRow $row): static
    {
        if ($this->rows->removeElement($row)) {
            // set the owning side to null (unless already changed)
            if ($row->getTableau() === $this) {
                $row->setTableau(null);
            }
        }

        return $this;
    }

    public function getBgCarac(): ?BGCarac
    {
        return $this->bg_carac;
    }

    public function setBgCarac(?BGCarac $bg_carac): static
    {
        $this->bg_carac = $bg_carac;

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
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        $this->items->removeElement($item);

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

    public function getSpell(): ?Spell
    {
        return $this->spell;
    }

    public function setSpell(?Spell $spell): static
    {
        $this->spell = $spell;

        return $this;
    }
}
