<?php

namespace App\Entity\Classes;

use App\Repository\Classes\ClasseTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseTableRepository::class)]
class ClasseTable
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
    private ?ClasseSkill $skill = null;

    /**
     * @var Collection<int, ClasseRow>
     */
    #[ORM\OneToMany(targetEntity: ClasseRow::class, mappedBy: 'tableau', orphanRemoval: true)]
    private Collection $rows;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
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

    public function getSkill(): ?ClasseSkill
    {
        return $this->skill;
    }

    public function setSkill(?ClasseSkill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, ClasseRow>
     */
    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function addRow(ClasseRow $row): static
    {
        if (!$this->rows->contains($row)) {
            $this->rows->add($row);
            $row->setTableau($this);
        }

        return $this;
    }

    public function removeRow(ClasseRow $row): static
    {
        if ($this->rows->removeElement($row)) {
            // set the owning side to null (unless already changed)
            if ($row->getTableau() === $this) {
                $row->setTableau(null);
            }
        }

        return $this;
    }
}
