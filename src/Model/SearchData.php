<?php
namespace App\Model;

class SearchData
{
    private ?string $titre = null;
    private ?string $acteur = null;
    private ?int $anneeSortie = null;
    private ?string $categorie = null;

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    public function getActeur(): ?string
    {
        return $this->acteur;
    }

    public function setActeur(?string $acteur): void
    {
        $this->acteur = $acteur;
    }

    public function getAnneeSortie(): ?int
    {
        return $this->anneeSortie;
    }

    public function setAnneeSortie(?int $anneeSortie): void
    {
        $this->anneeSortie = $anneeSortie;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): void
    {
        $this->categorie = $categorie;
    }
}
