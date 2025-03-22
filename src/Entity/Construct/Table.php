<?php

namespace App\Entity\Construct;

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
    private Collection $tableRows;

    public function __construct()
    {
        $this->tableRows = new ArrayCollection();
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
        return $this->tableRows;
    }

    public function addTableRow(TableRow $tableRow): static
    {
        if (!$this->tableRows->contains($tableRow)) {
            $this->tableRows->add($tableRow);
            $tableRow->setTableau($this);
        }

        return $this;
    }

    public function removeTableRow(TableRow $tableRow): static
    {
        if ($this->tableRows->removeElement($tableRow)) {
            // set the owning side to null (unless already changed)
            if ($tableRow->getTableau() === $this) {
                $tableRow->setTableau(null);
            }
        }

        return $this;
    }
}
