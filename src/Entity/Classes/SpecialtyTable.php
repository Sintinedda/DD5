<?php

namespace App\Entity\Classes;

use App\Repository\Classes\SpecialtyTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialtyTableRepository::class)]
class SpecialtyTable
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
    private ?SpecialtySkill $skill = null;

    /**
     * @var Collection<int, SpecialtyRow>
     */
    #[ORM\OneToMany(targetEntity: SpecialtyRow::class, mappedBy: 'tableau', orphanRemoval: true)]
    private Collection $rows;

    /**
     * @var Collection<int, SpecialtyItem>
     */
    #[ORM\ManyToMany(targetEntity: SpecialtyItem::class, mappedBy: 'tables')]
    private Collection $specialties;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
        $this->specialties = new ArrayCollection();
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

    public function getSkill(): ?SpecialtySkill
    {
        return $this->skill;
    }

    public function setSkill(?SpecialtySkill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, SpecialtyRow>
     */
    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function addRow(SpecialtyRow $row): static
    {
        if (!$this->rows->contains($row)) {
            $this->rows->add($row);
            $row->setTableau($this);
        }

        return $this;
    }

    public function removeRow(SpecialtyRow $row): static
    {
        if ($this->rows->removeElement($row)) {
            // set the owning side to null (unless already changed)
            if ($row->getTableau() === $this) {
                $row->setTableau(null);
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
            $specialty->addTable($this);
        }

        return $this;
    }

    public function removeSpecialty(SpecialtyItem $specialty): static
    {
        if ($this->specialties->removeElement($specialty)) {
            $specialty->removeTable($this);
        }

        return $this;
    }
}
