<?php

namespace App\Entity;

use App\Repository\CongesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\PseudoTypes\True_;

#[ORM\Entity(repositoryClass: CongesRepository::class)]
class Conges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    private ?bool $estValide = null;

    #[ORM\ManyToOne(inversedBy: 'conges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $ref_pilote = null;

    #[ORM\ManyToOne(inversedBy: 'congesValideAdmin')]
    #[ORM\JoinColumn(nullable: True)]
    private ?Utilisateur $ref_validation_admin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function isEstValide(): ?bool
    {
        return $this->estValide;
    }

    public function setEstValide(bool $estValide): static
    {
        $this->estValide = $estValide;

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

    public function getRefValidationAdmin(): ?Utilisateur
    {
        return $this->ref_validation_admin;
    }

    public function setRefValidationAdmin(?Utilisateur $ref_validation_admin): static
    {
        $this->ref_validation_admin = $ref_validation_admin;

        return $this;
    }
}
