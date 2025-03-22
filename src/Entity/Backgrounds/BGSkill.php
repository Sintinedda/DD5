<?php

namespace App\Entity\Backgrounds;

use App\Repository\Backgrounds\BGSkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BGSkillRepository::class)]
class BGSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

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

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d6 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d7 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d8 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d9 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $d10 = null;

    /**
     * @var Collection<int, BGListe>
     */
    #[ORM\OneToMany(targetEntity: BGListe::class, mappedBy: 'skill')]
    private Collection $listes;

    /**
     * @var Collection<int, BGTable>
     */
    #[ORM\OneToMany(targetEntity: BGTable::class, mappedBy: 'skill')]
    private Collection $tables;

    /**
     * @var Collection<int, BG>
     */
    #[ORM\ManyToMany(targetEntity: BG::class, mappedBy: 'skills')]
    private Collection $bGs;

    public function __construct()
    {
        $this->listes = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->bGs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getD6(): ?string
    {
        return $this->d6;
    }

    public function setD6(?string $d6): static
    {
        $this->d6 = $d6;

        return $this;
    }

    public function getD7(): ?string
    {
        return $this->d7;
    }

    public function setD7(?string $d7): static
    {
        $this->d7 = $d7;

        return $this;
    }

    public function getD8(): ?string
    {
        return $this->d8;
    }

    public function setD8(?string $d8): static
    {
        $this->d8 = $d8;

        return $this;
    }

    public function getD9(): ?string
    {
        return $this->d9;
    }

    public function setD9(?string $d9): static
    {
        $this->d9 = $d9;

        return $this;
    }

    public function getD10(): ?string
    {
        return $this->d10;
    }

    public function setD10(?string $d10): static
    {
        $this->d10 = $d10;

        return $this;
    }

    /**
     * @return Collection<int, BGListe>
     */
    public function getListes(): Collection
    {
        return $this->listes;
    }

    public function addListe(BGListe $liste): static
    {
        if (!$this->listes->contains($liste)) {
            $this->listes->add($liste);
            $liste->setSkill($this);
        }

        return $this;
    }

    public function removeListe(BGListe $liste): static
    {
        if ($this->listes->removeElement($liste)) {
            // set the owning side to null (unless already changed)
            if ($liste->getSkill() === $this) {
                $liste->setSkill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BGTable>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(BGTable $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->setSkill($this);
        }

        return $this;
    }

    public function removeTable(BGTable $table): static
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getSkill() === $this) {
                $table->setSkill(null);
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
            $bG->addSkill($this);
        }

        return $this;
    }

    public function removeBG(BG $bG): static
    {
        if ($this->bGs->removeElement($bG)) {
            $bG->removeSkill($this);
        }

        return $this;
    }
}
