<?php

namespace App\Entity\Assets;

use App\Entity\Monsters\SB;
use App\Repository\Assets\SenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SenseRepository::class)]
class Sense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $abbreviation = null;

    /**
     * @var Collection<int, SB>
     */
    #[ORM\ManyToMany(targetEntity: SB::class, mappedBy: 'sens')]
    private Collection $sBs;

    public function __construct()
    {
        $this->sBs = new ArrayCollection();
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
            $sB->addSen($this);
        }

        return $this;
    }

    public function removeSB(SB $sB): static
    {
        if ($this->sBs->removeElement($sB)) {
            $sB->removeSen($this);
        }

        return $this;
    }
}
