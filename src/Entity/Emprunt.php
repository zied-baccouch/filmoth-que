<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dh_emprunt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dh_retour = null;

    #[ORM\ManyToOne(inversedBy: 'cin')]
    private ?Adherent $adherent = null;

    #[ORM\ManyToOne(inversedBy: 'created_at')]
    private ?Film $film = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDhEmprunt(): ?\DateTimeInterface
    {
        return $this->dh_emprunt;
    }

    public function setDhEmprunt(\DateTimeInterface $dh_emprunt): static
    {
        $this->dh_emprunt = $dh_emprunt;

        return $this;
    }

    public function getDhRetour(): ?\DateTimeInterface
    {
        return $this->dh_retour;
    }

    public function setDhRetour(\DateTimeInterface $dh_retour): static
    {
        $this->dh_retour = $dh_retour;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): static
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): static
    {
        $this->film = $film;

        return $this;
    }
}
