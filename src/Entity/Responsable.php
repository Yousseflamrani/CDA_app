<?php

namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponsableRepository::class)]
class Responsable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'responsable', targetEntity: Affaire::class)]
    private Collection $affaires;


    /**
     * @ORM\OneToOne(targetEntity=Section::class, mappedBy="responsable", cascade={"persist", "remove"})
     */
    private $section;


    public function __construct()
    {
        $this->affaires = new ArrayCollection();
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
     * @return Collection<int, Affaire>
     */
    public function getAffaires(): Collection
    {
        return $this->affaires;
    }

    public function addAffaire(Affaire $affaire): static
    {
        if (!$this->affaires->contains($affaire)) {
            $this->affaires->add($affaire);
            $affaire->setResponsable($this);
        }

        return $this;
    }

    public function removeAffaire(Affaire $affaire): static
    {
        if ($this->affaires->removeElement($affaire)) {
            // set the owning side to null (unless already changed)
            if ($affaire->getResponsable() === $this) {
                $affaire->setResponsable(null);
            }
        }

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(Section $section): self
    {
        $this->section = $section;

        return $this;
    }






    public function __toString(){

        return $this->name;
    }
}
