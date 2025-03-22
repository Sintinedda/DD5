<?php

namespace App\Entity\Assets;

use App\Entity\Monsters\SB;
use App\Repository\Assets\CreatureTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreatureTypeRepository::class)]
class CreatureType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $abbreviation = null;

    /**
     * @var Collection<int, SB>
     */
    #[ORM\OneToMany(targetEntity: SB::class, mappedBy: 'type')]
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
            $sB->setType($this);
        }

        return $this;
    }

    public function removeSB(SB $sB): static
    {
        if ($this->sBs->removeElement($sB)) {
            // set the owning side to null (unless already changed)
            if ($sB->getType() === $this) {
                $sB->setType(null);
            }
        }

        return $this;
    }
}
