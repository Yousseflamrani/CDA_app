<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;  

    #[ORM\ManyToMany(targetEntity: Affaire::class, mappedBy: 'section')]
    private Collection $affaires;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: User::class)]
    private Collection $users;  

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Responsable $responsable = null;

    public function __construct()
    {
        $this->affaires = new ArrayCollection();
        $this->users = new ArrayCollection();  
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;  
    }

    public function setName(string $name): self  
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

    public function addAffaire(Affaire $affaire): self
    {
        if (!$this->affaires->contains($affaire)) {
            $this->affaires->add($affaire);
            $affaire->addSection($this);
        }

        return $this;
    }

    public function removeAffaire(Affaire $affaire): self
    {
        if ($this->affaires->removeElement($affaire)) {
            $affaire->removeSection($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection  
    {
        return $this->users;  
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {  
            $this->users->add($user);  
            $user->setSection($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) { 
           
            if ($user->getSection() === $this) {
                $user->setSection(null);
            }
        }

        return $this;
    }

    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function setResponsable(?Responsable $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;  
    }
}
