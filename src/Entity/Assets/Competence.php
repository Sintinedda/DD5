<?php

namespace App\Entity\Assets;

use App\Entity\Backgrounds\BG;
use App\Entity\Classes\Classe;
use App\Repository\Assets\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, BG>
     */
    #[ORM\ManyToMany(targetEntity: BG::class, mappedBy: 'competences')]
    private Collection $bGs;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'competences')]
    private Collection $classes;

    #[ORM\Column(length: 20)]
    private ?string $category = null;

    public function __construct()
    {
        $this->bGs = new ArrayCollection();
        $this->classes = new ArrayCollection();
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
            $bG->addCompetence($this);
        }

        return $this;
    }

    public function removeBG(BG $bG): static
    {
        if ($this->bGs->removeElement($bG)) {
            $bG->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->addCompetence($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): static
    {
        if ($this->classes->removeElement($class)) {
            $class->removeCompetence($this);
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}
