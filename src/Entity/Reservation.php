<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prixBillet = null;

    #[ORM\ManyToOne(inversedBy: 'refVols')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vol $refVol = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: Utilisateur::class)]
    private Collection $refUtilisateur;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $ref_Utilisateur = null;

    public function __construct()
    {
        $this->refUtilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixBillet(): ?float
    {
        return $this->prixBillet;
    }

    public function setPrixBillet(float $prixBillet): static
    {
        $this->prixBillet = $prixBillet;

        return $this;
    }

    public function getRefVol(): ?Vol
    {
        return $this->refVol;
    }

    public function setRefVol(?Vol $refVol): static
    {
        $this->refVol = $refVol;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getRefUtilisateur(): Collection
    {
        return $this->refUtilisateur;
    }

    public function addRefUtilisateur(Utilisateur $refUtilisateur): static
    {
        if (!$this->refUtilisateur->contains($refUtilisateur)) {
            $this->refUtilisateur->add($refUtilisateur);
            $refUtilisateur->setReservation($this);
        }

        return $this;
    }

    public function removeRefUtilisateur(Utilisateur $refUtilisateur): static
    {
        if ($this->refUtilisateur->removeElement($refUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($refUtilisateur->getReservation() === $this) {
                $refUtilisateur->setReservation(null);
            }
        }

        return $this;
    }

    public function setRefUtilisateur(?Utilisateur $ref_Utilisateur): static
    {
        $this->ref_Utilisateur = $ref_Utilisateur;

        return $this;
    }
}
