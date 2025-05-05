<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolRepository::class)]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $villeDepart = null;

    #[ORM\Column(length: 50)]
    private ?string $villeArrive = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDepart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureDepart = null;

    #[ORM\Column]
    private ?float $prixBilletInitial = null;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avion $refAvion = null;

    #[ORM\OneToMany(mappedBy: 'refVol', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $refVols;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $ref_pilote = null;

    public function __construct()
    {
        $this->refVols = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): static
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleArrive(): ?string
    {
        return $this->villeArrive;
    }

    public function setVilleArrive(string $villeArrive): static
    {
        $this->villeArrive = $villeArrive;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(\DateTimeInterface $heureDepart): static
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getPrixBilletInitial(): ?float
    {
        return $this->prixBilletInitial;
    }

    public function setPrixBilletInitial(float $prixBilletInitial): static
    {
        $this->prixBilletInitial = $prixBilletInitial;

        return $this;
    }

    public function getRefAvion(): ?Avion
    {
        return $this->refAvion;
    }

    public function setRefAvion(?Avion $refAvion): static
    {
        $this->refAvion = $refAvion;

        return $this;
    }


    /**
     * @return Collection<int, Reservation>
     */
    public function getRefVols(): Collection
    {
        return $this->refVols;
    }

    public function addRefVol(Reservation $refVol): static
    {
        if (!$this->refVols->contains($refVol)) {
            $this->refVols->add($refVol);
            $refVol->setRefVol($this);
        }

        return $this;
    }

    public function removeRefVol(Reservation $refVol): static
    {
        if ($this->refVols->removeElement($refVol)) {
            // set the owning side to null (unless already changed)
            if ($refVol->getRefVol() === $this) {
                $refVol->setRefVol(null);
            }
        }

        return $this;
    }

    public function getRefPilote(): ?Utilisateur
    {
        return $this->ref_pilote;
    }

    public function setRefPilote(?Utilisateur $ref_pilote): static
    {
        $this->ref_pilote = $ref_pilote;

        return $this;
    }
}
