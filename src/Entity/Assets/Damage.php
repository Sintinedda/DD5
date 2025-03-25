<?php

namespace App\Entity\Assets;

use App\Entity\Items\Item;
use App\Entity\Monsters\SBSkill;
use App\Repository\Assets\DamageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DamageRepository::class)]
class Damage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'damage2')]
    private Collection $items;

    /**
     * @var Collection<int, SBSkill>
     */
    #[ORM\OneToMany(targetEntity: SBSkill::class, mappedBy: 'damage')]
    private Collection $sBSkills;

    #[ORM\Column(length: 255)]
    private ?string $abbreviation = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $part = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->sBSkills = new ArrayCollection();
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
            $item->setDamage2($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getDamage2() === $this) {
                $item->setDamage2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SBSkill>
     */
    public function getSBSkills(): Collection
    {
        return $this->sBSkills;
    }

    public function addSBSkill(SBSkill $sBSkill): static
    {
        if (!$this->sBSkills->contains($sBSkill)) {
            $this->sBSkills->add($sBSkill);
            $sBSkill->setDamage($this);
        }

        return $this;
    }

    public function removeSBSkill(SBSkill $sBSkill): static
    {
        if ($this->sBSkills->removeElement($sBSkill)) {
            // set the owning side to null (unless already changed)
            if ($sBSkill->getDamage() === $this) {
                $sBSkill->setDamage(null);
            }
        }

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

    public function getPart(): ?string
    {
        return $this->part;
    }

    public function setPart(?string $part): static
    {
        $this->part = $part;

        return $this;
    }
}
