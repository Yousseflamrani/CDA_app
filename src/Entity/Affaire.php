<?php

namespace App\Entity;

use App\Repository\AffaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffaireRepository::class)]
class Affaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $compte_c6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phase = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $journalaffiare = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_de_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_de_fin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $echeance = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'affaires')]
    private Collection $user;

    #[ORM\ManyToOne(inversedBy: 'affaires')]
    private ?Responsable $responsable = null;

    #[ORM\ManyToMany(targetEntity: Section::class, inversedBy: 'affaires')]
    private Collection $section;

   

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->section = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCompteC6(): ?string
    {
        return $this->compte_c6;
    }

    public function setCompteC6(string $compte_c6): static
    {
        $this->compte_c6 = $compte_c6;

        return $this;
    }

    public function getPhase(): ?string
    {
        return $this->phase;
    }

    public function setPhase(?string $phase): static
    {
        $this->phase = $phase;

        return $this;
    }

    public function getJournalaffiare(): ?string
    {
        return $this->journalaffiare;
    }

    public function setJournalaffiare(?string $journalaffiare): static
    {
        $this->journalaffiare = $journalaffiare;

        return $this;
    }

    public function getDateDeDebut(): ?\DateTimeInterface
    {
        return $this->date_de_debut;
    }

    public function setDateDeDebut(\DateTimeInterface $date_de_debut): static
    {
        $this->date_de_debut = $date_de_debut;

        return $this;
    }

    public function getDateDeFin(): ?\DateTimeInterface
    {
        return $this->date_de_fin;
    }

    public function setDateDeFin(?\DateTimeInterface $date_de_fin): static
    {
        $this->date_de_fin = $date_de_fin;

        return $this;
    }

    public function getEcheance(): ?\DateTimeInterface
    {
        return $this->echeance;
    }

    public function setEcheance(?\DateTimeInterface $echeance): static
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function setResponsable(?Responsable $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->section;
    }
    

    public function addSection(Section $section): static
    {
        if (!$this->section->contains($section)) {
            $this->section[] = $section;
            $section->setAffaire($this);
        }


        return $this;
    }

    public function removeSection(Section $section): static
    {
        if ($section->getAffaire() === $this) {
            $section->setAffaire(null);
        }

        return $this;
    }
    public function __toString(){

        return $this->title;

    }
   
}
