<?php

namespace App\Entity\Races;

use App\Repository\Races\RaceTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceTableRepository::class)]
class RaceTable
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
    private ?RaceSkill $skill = null;

    /**
     * @var Collection<int, RaceRow>
     */
    #[ORM\OneToMany(targetEntity: RaceRow::class, mappedBy: 'tableau', orphanRemoval: true)]
    private Collection $rows;

    /**
     * @var Collection<int, RaceSource>
     */
    #[ORM\ManyToMany(targetEntity: RaceSource::class, mappedBy: 'tables')]
    private Collection $sources;

    /**
     * @var Collection<int, RaceSubrace>
     */
    #[ORM\ManyToMany(targetEntity: RaceSubrace::class, mappedBy: 'tables')]
    private Collection $subraces;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->subraces = new ArrayCollection();
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

    public function getSkill(): ?RaceSkill
    {
        return $this->skill;
    }

    public function setSkill(?RaceSkill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, RaceRow>
     */
    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function addRow(RaceRow $row): static
    {
        if (!$this->rows->contains($row)) {
            $this->rows->add($row);
            $row->setTableau($this);
        }

        return $this;
    }

    public function removeRow(RaceRow $row): static
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
     * @return Collection<int, RaceSource>
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(RaceSource $source): static
    {
        if (!$this->sources->contains($source)) {
            $this->sources->add($source);
            $source->addTable($this);
        }

        return $this;
    }

    public function removeSource(RaceSource $source): static
    {
        if ($this->sources->removeElement($source)) {
            $source->removeTable($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RaceSubrace>
     */
    public function getSubraces(): Collection
    {
        return $this->subraces;
    }

    public function addSubrace(RaceSubrace $subrace): static
    {
        if (!$this->subraces->contains($subrace)) {
            $this->subraces->add($subrace);
            $subrace->addTable($this);
        }

        return $this;
    }

    public function removeSubrace(RaceSubrace $subrace): static
    {
        if ($this->subraces->removeElement($subrace)) {
            $subrace->removeTable($this);
        }

        return $this;
    }
}
