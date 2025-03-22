<?php

namespace App\Entity\Assets;

use App\Entity\Backgrounds\BG;
use App\Entity\Classes\SpecialtyItem;
use App\Entity\Items\Item;
use App\Entity\Items\ItemCategory;
use App\Entity\Monsters\SB;
use App\Entity\Races\RaceSource;
use App\Entity\Spells\Spell;
use App\Repository\Assets\SourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $abbreviation = null;

    /**
     * @var Collection<int, SourcePart>
     */
    #[ORM\OneToMany(targetEntity: SourcePart::class, mappedBy: 'source', orphanRemoval: true)]
    private Collection $parts;

    /**
     * @var Collection<int, Feat>
     */
    #[ORM\OneToMany(targetEntity: Feat::class, mappedBy: 'source', orphanRemoval: true)]
    private Collection $feats;

    /**
     * @var Collection<int, BG>
     */
    #[ORM\OneToMany(targetEntity: BG::class, mappedBy: 'source')]
    private Collection $bGs;

    /**
     * @var Collection<int, SpecialtyItem>
     */
    #[ORM\ManyToMany(targetEntity: SpecialtyItem::class, mappedBy: 'source')]
    private Collection $specialties;

    /**
     * @var Collection<int, ItemCategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemCategory::class, mappedBy: 'source')]
    private Collection $itemCategories;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'source')]
    private Collection $items;

    /**
     * @var Collection<int, SB>
     */
    #[ORM\OneToMany(targetEntity: SB::class, mappedBy: 'source')]
    private Collection $sBs;

    /**
     * @var Collection<int, Spell>
     */
    #[ORM\OneToMany(targetEntity: Spell::class, mappedBy: 'source')]
    private Collection $spells;

    /**
     * @var Collection<int, RaceSource>
     */
    #[ORM\OneToMany(targetEntity: RaceSource::class, mappedBy: 'source')]
    private Collection $races;

    public function __construct()
    {
        $this->parts = new ArrayCollection();
        $this->feats = new ArrayCollection();
        $this->bGs = new ArrayCollection();
        $this->specialties = new ArrayCollection();
        $this->itemCategories = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->sBs = new ArrayCollection();
        $this->spells = new ArrayCollection();
        $this->races = new ArrayCollection();
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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return Collection<int, SourcePart>
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(SourcePart $part): static
    {
        if (!$this->parts->contains($part)) {
            $this->parts->add($part);
            $part->setSource($this);
        }

        return $this;
    }

    public function removePart(SourcePart $part): static
    {
        if ($this->parts->removeElement($part)) {
            // set the owning side to null (unless already changed)
            if ($part->getSource() === $this) {
                $part->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Feat>
     */
    public function getFeats(): Collection
    {
        return $this->feats;
    }

    public function addFeat(Feat $feat): static
    {
        if (!$this->feats->contains($feat)) {
            $this->feats->add($feat);
            $feat->setSource($this);
        }

        return $this;
    }

    public function removeFeat(Feat $feat): static
    {
        if ($this->feats->removeElement($feat)) {
            // set the owning side to null (unless already changed)
            if ($feat->getSource() === $this) {
                $feat->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BG>
     */
    public function getBGs(): Collection
    {
        return $this->bGs;
    }

    public function addBG(BG $bG): static
    {
        if (!$this->bGs->contains($bG)) {
            $this->bGs->add($bG);
            $bG->setSource($this);
        }

        return $this;
    }

    public function removeBG(BG $bG): static
    {
        if ($this->bGs->removeElement($bG)) {
            // set the owning side to null (unless already changed)
            if ($bG->getSource() === $this) {
                $bG->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SpecialtyItem>
     */
    public function getSpecialties(): Collection
    {
        return $this->specialties;
    }

    public function addSpecialty(SpecialtyItem $specialty): static
    {
        if (!$this->specialties->contains($specialty)) {
            $this->specialties->add($specialty);
            $specialty->addSource($this);
        }

        return $this;
    }

    public function removeSpecialty(SpecialtyItem $specialty): static
    {
        if ($this->specialties->removeElement($specialty)) {
            $specialty->removeSource($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemCategory>
     */
    public function getItemCategories(): Collection
    {
        return $this->itemCategories;
    }

    public function addItemCategory(ItemCategory $itemCategory): static
    {
        if (!$this->itemCategories->contains($itemCategory)) {
            $this->itemCategories->add($itemCategory);
            $itemCategory->addSource($this);
        }

        return $this;
    }

    public function removeItemCategory(ItemCategory $itemCategory): static
    {
        if ($this->itemCategories->removeElement($itemCategory)) {
            $itemCategory->removeSource($this);
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
            $item->setSource($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSource() === $this) {
                $item->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SB>
     */
    public function getSBs(): Collection
    {
        return $this->sBs;
    }

    public function addSB(SB $sB): static
    {
        if (!$this->sBs->contains($sB)) {
            $this->sBs->add($sB);
            $sB->setSource($this);
        }

        return $this;
    }

    public function removeSB(SB $sB): static
    {
        if ($this->sBs->removeElement($sB)) {
            // set the owning side to null (unless already changed)
            if ($sB->getSource() === $this) {
                $sB->setSource(null);
            }
        }

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
            $spell->setSource($this);
        }

        return $this;
    }

    public function removeSpell(Spell $spell): static
    {
        if ($this->spells->removeElement($spell)) {
            // set the owning side to null (unless already changed)
            if ($spell->getSource() === $this) {
                $spell->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RaceSource>
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(RaceSource $race): static
    {
        if (!$this->races->contains($race)) {
            $this->races->add($race);
            $race->setSource($this);
        }

        return $this;
    }

    public function removeRace(RaceSource $race): static
    {
        if ($this->races->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getSource() === $this) {
                $race->setSource(null);
            }
        }

        return $this;
    }
}
