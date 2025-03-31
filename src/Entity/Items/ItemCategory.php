<?php

namespace App\Entity\Items;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Entity\Construct\Skill;
use App\Entity\Items\ItemSubcategory;
use App\Repository\Items\ItemCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemCategoryRepository::class)]
class ItemCategory
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

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d4 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d5 = null;

    /**
     * @var Collection<int, Source>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, inversedBy: 'itemCategories')]
    private Collection $source;

    /**
     * @var Collection<int, SourcePart>
     */
    #[ORM\ManyToMany(targetEntity: SourcePart::class, inversedBy: 'itemCategories')]
    private Collection $source_part;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\OneToMany(targetEntity: ItemSubcategory::class, mappedBy: 'category')]
    private Collection $subcategories;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'category')]
    private Collection $items;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'item_categories')]
    private Collection $skills;

    public function __construct()
    {
        $this->source = new ArrayCollection();
        $this->source_part = new ArrayCollection();
        $this->subcategories = new ArrayCollection();
        $this->items = new ArrayCollection();
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
     * @return Collection<int, ItemSubcategory>
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(ItemSubcategory $subcategory): static
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories->add($subcategory);
            $subcategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubcategory(ItemSubcategory $subcategory): static
    {
        if ($this->subcategories->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategory() === $this) {
                $subcategory->setCategory(null);
            }
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
            $item->setCategory($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getCategory() === $this) {
                $item->setCategory(null);
            }
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
            $skill->addItemCategory($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeItemCategory($this);
        }

        return $this;
    }
}
