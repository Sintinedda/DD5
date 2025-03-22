<?php

namespace App\Entity\Assets;

use App\Entity\Construct\Skill;
use App\Repository\Assets\FeatRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeatRepository::class)]
class Feat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prerequisite = null;

    #[ORM\ManyToOne(inversedBy: 'feats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Source $source = null;

    #[ORM\ManyToOne(inversedBy: 'feats')]
    private ?SourcePart $source_part = null;

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

    public function getPrerequisite(): ?string
    {
        return $this->prerequisite;
    }

    public function setPrerequisite(?string $prerequisite): static
    {
        $this->prerequisite = $prerequisite;

        return $this;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(?Source $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getSourcePart(): ?SourcePart
    {
        return $this->source_part;
    }

    public function setSourcePart(?SourcePart $source_part): static
    {
        $this->source_part = $source_part;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setFeat($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getFeat() === $this) {
                $skill->setFeat(null);
            }
        }

        return $this;
    }
}
