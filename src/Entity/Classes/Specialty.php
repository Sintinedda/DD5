<?php

namespace App\Entity\Classes;

use App\Repository\Classes\SpecialtyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialtyRepository::class)]
class Specialty
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
    private ?string $d = null;

    #[ORM\OneToOne(inversedBy: 'specialty', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classe = null;

    /**
     * @var Collection<int, SpecialtyItem>
     */
    #[ORM\ManyToMany(targetEntity: SpecialtyItem::class, mappedBy: 'specialty')]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function setD(?string $d): static
    {
        $this->d = $d;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, SpecialtyItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(SpecialtyItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->addSpecialty($this);
        }

        return $this;
    }

    public function removeItem(SpecialtyItem $item): static
    {
        if ($this->items->removeElement($item)) {
            $item->removeSpecialty($this);
        }

        return $this;
    }
}
