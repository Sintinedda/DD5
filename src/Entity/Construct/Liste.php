<?php

namespace App\Entity\Construct;

use App\Entity\Items\ItemSubcategory;
use App\Entity\Spells\Spell;
use App\Repository\Construct\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeRepository::class)]
class Liste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?int $place = null;

    #[ORM\Column(length: 1000)]
    private ?string $l1 = null;

    #[ORM\Column(length: 1000)]
    private ?string $l2 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l3 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l4 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l5 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l6 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l7 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l8 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l9 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $l10 = null;

    #[ORM\ManyToOne(inversedBy: 'listes')]
    private ?Skill $skill = null;

    /**
     * @var Collection<int, ItemSubcategory>
     */
    #[ORM\ManyToMany(targetEntity: ItemSubcategory::class, inversedBy: 'listes')]
    private Collection $item_subcategories;

    #[ORM\ManyToOne(inversedBy: 'listes')]
    private ?Spell $spell = null;

    public function __construct()
    {
        $this->item_subcategories = new ArrayCollection();
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

    public function getL1(): ?string
    {
        return $this->l1;
    }

    public function setL1(string $l1): static
    {
        $this->l1 = $l1;

        return $this;
    }

    public function getL2(): ?string
    {
        return $this->l2;
    }

    public function setL2(string $l2): static
    {
        $this->l2 = $l2;

        return $this;
    }

    public function getL3(): ?string
    {
        return $this->l3;
    }

    public function setL3(?string $l3): static
    {
        $this->l3 = $l3;

        return $this;
    }

    public function getL4(): ?string
    {
        return $this->l4;
    }

    public function setL4(?string $l4): static
    {
        $this->l4 = $l4;

        return $this;
    }

    public function getL5(): ?string
    {
        return $this->l5;
    }

    public function setL5(?string $l5): static
    {
        $this->l5 = $l5;

        return $this;
    }

    public function getL6(): ?string
    {
        return $this->l6;
    }

    public function setL6(?string $l6): static
    {
        $this->l6 = $l6;

        return $this;
    }

    public function getL7(): ?string
    {
        return $this->l7;
    }

    public function setL7(?string $l7): static
    {
        $this->l7 = $l7;

        return $this;
    }

    public function getL8(): ?string
    {
        return $this->l8;
    }

    public function setL8(?string $l8): static
    {
        $this->l8 = $l8;

        return $this;
    }

    public function getL9(): ?string
    {
        return $this->l9;
    }

    public function setL9(?string $l9): static
    {
        $this->l9 = $l9;

        return $this;
    }

    public function getL10(): ?string
    {
        return $this->l10;
    }

    public function setL10(?string $l10): static
    {
        $this->l10 = $l10;

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
