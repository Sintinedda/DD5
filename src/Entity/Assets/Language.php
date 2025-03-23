<?php

namespace App\Entity\Assets;

use App\Entity\Backgrounds\BG;
use App\Entity\Races\RaceSource;
use App\Repository\Assets\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $name = null;

    /**
     * @var Collection<int, BG>
     */
    #[ORM\ManyToMany(targetEntity: BG::class, mappedBy: 'Language')]
    private Collection $bGs;

    /**
     * @var Collection<int, RaceSource>
     */
    #[ORM\ManyToMany(targetEntity: RaceSource::class, mappedBy: 'languages')]
    private Collection $races;

    #[ORM\Column(length: 20)]
    private ?string $abbreviation = null;

    public function __construct()
    {
        $this->bGs = new ArrayCollection();
        $this->races = new ArrayCollection();
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
            $bG->addLanguage($this);
        }

        return $this;
    }

    public function removeBG(BG $bG): static
    {
        if ($this->bGs->removeElement($bG)) {
            $bG->removeLanguage($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RaceSource>
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(RaceSource $race): static
    {
        if (!$this->races->contains($race)) {
            $this->races->add($race);
            $race->addLanguage($this);
        }

        return $this;
    }

    public function removeRace(RaceSource $race): static
    {
        if ($this->races->removeElement($race)) {
            $race->removeLanguage($this);
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
}
