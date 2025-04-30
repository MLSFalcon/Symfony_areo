<?php

namespace App\Entity;

use App\Repository\ModeleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModeleRepository::class)]
class Modele
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\OneToMany(mappedBy: 'refModele', targetEntity: Avion::class, orphanRemoval: true)]
    private Collection $refAvions;

    #[ORM\OneToMany(mappedBy: 'refModele', targetEntity: Utilisateur::class)]
    private Collection $refUtilisateurs;

    #[ORM\OneToMany(mappedBy: 'ref_modele', targetEntity: Utilisateur::class)]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->refAvions = new ArrayCollection();
        $this->refUtilisateurs = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->marque." ".$this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, Avion>
     */
    public function getRefAvions(): Collection
    {
        return $this->refAvions;
    }

    public function addRefAvion(Avion $refAvion): static
    {
        if (!$this->refAvions->contains($refAvion)) {
            $this->refAvions->add($refAvion);
            $refAvion->setRefModele($this);
        }

        return $this;
    }

    public function removeRefAvion(Avion $refAvion): static
    {
        if ($this->refAvions->removeElement($refAvion)) {
            // set the owning side to null (unless already changed)
            if ($refAvion->getRefModele() === $this) {
                $refAvion->setRefModele(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getRefUtilisateurs(): Collection
    {
        return $this->refUtilisateurs;
    }

    public function addRefUtilisateur(Utilisateur $refUtilisateur): static
    {
        if (!$this->refUtilisateurs->contains($refUtilisateur)) {
            $this->refUtilisateurs->add($refUtilisateur);
            $refUtilisateur->setRefModele($this);
        }

        return $this;
    }

    public function removeRefUtilisateur(Utilisateur $refUtilisateur): static
    {
        if ($this->refUtilisateurs->removeElement($refUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($refUtilisateur->getRefModele() === $this) {
                $refUtilisateur->setRefModele(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setRefModele($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getRefModele() === $this) {
                $utilisateur->setRefModele(null);
            }
        }

        return $this;
    }
}
