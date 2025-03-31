<?php

namespace App\Entity\Classes;

use App\Entity\Construct\Skill;
use App\Repository\Classes\ClasseLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseLevelRepository::class)]
class ClasseLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classe = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $bm = null;

    #[ORM\Column(nullable: true)]
    private ?int $cantrip_know = null;

    #[ORM\Column(nullable: true)]
    private ?int $spell_know = null;

    #[ORM\Column(nullable: true)]
    private ?int $s1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s4 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s5 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s6 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s7 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s8 = null;

    #[ORM\Column(nullable: true)]
    private ?int $s9 = null;

    #[ORM\Column(nullable: true)]
    private ?int $infusion_know = null;

    #[ORM\Column(nullable: true)]
    private ?int $infused_item = null;

    #[ORM\Column(nullable: true)]
    private ?int $rage = null;

    #[ORM\Column(nullable: true)]
    private ?int $rage_damage = null;

    #[ORM\Column(nullable: true)]
    private ?int $martial_art = null;

    #[ORM\Column(nullable: true)]
    private ?int $ki = null;

    #[ORM\Column(nullable: true)]
    private ?float $unarmored_move = null;

    #[ORM\Column(nullable: true)]
    private ?int $sneak_attack = null;

    #[ORM\Column(nullable: true)]
    private ?int $sorcery_point = null;

    #[ORM\Column(nullable: true)]
    private ?int $spell_slot = null;

    #[ORM\Column(nullable: true)]
    private ?int $slot_level = null;

    #[ORM\Column(nullable: true)]
    private ?int $invocation_know = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'classe_levels')]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getBm(): ?int
    {
        return $this->bm;
    }

    public function setBm(int $bm): static
    {
        $this->bm = $bm;

        return $this;
    }

    public function getCantripKnow(): ?int
    {
        return $this->cantrip_know;
    }

    public function setCantripKnow(?int $cantrip_know): static
    {
        $this->cantrip_know = $cantrip_know;

        return $this;
    }

    public function getSpellKnow(): ?int
    {
        return $this->spell_know;
    }

    public function setSpellKnow(?int $spell_know): static
    {
        $this->spell_know = $spell_know;

        return $this;
    }

    public function getS1(): ?int
    {
        return $this->s1;
    }

    public function setS1(?int $s1): static
    {
        $this->s1 = $s1;

        return $this;
    }

    public function getS2(): ?int
    {
        return $this->s2;
    }

    public function setS2(?int $s2): static
    {
        $this->s2 = $s2;

        return $this;
    }

    public function getS3(): ?int
    {
        return $this->s3;
    }

    public function setS3(?int $s3): static
    {
        $this->s3 = $s3;

        return $this;
    }

    public function getS4(): ?int
    {
        return $this->s4;
    }

    public function setS4(?int $s4): static
    {
        $this->s4 = $s4;

        return $this;
    }

    public function getS5(): ?int
    {
        return $this->s5;
    }

    public function setS5(?int $s5): static
    {
        $this->s5 = $s5;

        return $this;
    }

    public function getS6(): ?int
    {
        return $this->s6;
    }

    public function setS6(?int $s6): static
    {
        $this->s6 = $s6;

        return $this;
    }

    public function getS7(): ?int
    {
        return $this->s7;
    }

    public function setS7(?int $s7): static
    {
        $this->s7 = $s7;

        return $this;
    }

    public function getS8(): ?int
    {
        return $this->s8;
    }

    public function setS8(?int $s8): static
    {
        $this->s8 = $s8;

        return $this;
    }

    public function getS9(): ?int
    {
        return $this->s9;
    }

    public function setS9(?int $s9): static
    {
        $this->s9 = $s9;

        return $this;
    }

    public function getInfusionKnow(): ?int
    {
        return $this->infusion_know;
    }

    public function setInfusionKnow(?int $infusion_know): static
    {
        $this->infusion_know = $infusion_know;

        return $this;
    }

    public function getInfusedItem(): ?int
    {
        return $this->infused_item;
    }

    public function setInfusedItem(?int $infused_item): static
    {
        $this->infused_item = $infused_item;

        return $this;
    }

    public function getRage(): ?int
    {
        return $this->rage;
    }

    public function setRage(?int $rage): static
    {
        $this->rage = $rage;

        return $this;
    }

    public function getRageDamage(): ?int
    {
        return $this->rage_damage;
    }

    public function setRageDamage(?int $rage_damage): static
    {
        $this->rage_damage = $rage_damage;

        return $this;
    }

    public function getMartialArt(): ?int
    {
        return $this->martial_art;
    }

    public function setMartialArt(?int $martial_art): static
    {
        $this->martial_art = $martial_art;

        return $this;
    }

    public function getKi(): ?int
    {
        return $this->ki;
    }

    public function setKi(?int $ki): static
    {
        $this->ki = $ki;

        return $this;
    }

    public function getUnarmoredMove(): ?float
    {
        return $this->unarmored_move;
    }

    public function setUnarmoredMove(?float $unarmored_move): static
    {
        $this->unarmored_move = $unarmored_move;

        return $this;
    }

    public function getSneakAttack(): ?int
    {
        return $this->sneak_attack;
    }

    public function setSneakAttack(?int $sneak_attack): static
    {
        $this->sneak_attack = $sneak_attack;

        return $this;
    }

    public function getSorceryPoint(): ?int
    {
        return $this->sorcery_point;
    }

    public function setSorceryPoint(?int $sorcery_point): static
    {
        $this->sorcery_point = $sorcery_point;

        return $this;
    }

    public function getSpellSlot(): ?int
    {
        return $this->spell_slot;
    }

    public function setSpellSlot(?int $spell_slot): static
    {
        $this->spell_slot = $spell_slot;

        return $this;
    }

    public function getSlotLevel(): ?int
    {
        return $this->slot_level;
    }

    public function setSlotLevel(?int $slot_level): static
    {
        $this->slot_level = $slot_level;

        return $this;
    }

    public function getInvocationKnow(): ?int
    {
        return $this->invocation_know;
    }

    public function setInvocationKnow(?int $invocation_know): static
    {
        $this->invocation_know = $invocation_know;

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
            $skill->addClasseLevel($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeClasseLevel($this);
        }

        return $this;
    }
}
