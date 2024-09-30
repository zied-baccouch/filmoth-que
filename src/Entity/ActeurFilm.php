<?php

namespace App\Entity;

use App\Repository\ActeurFilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActeurFilmRepository::class)]
class ActeurFilm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Film>
     */
    #[ORM\OneToMany(targetEntity: Film::class, mappedBy: 'acteurFilm')]
    private Collection $id_film;

    /**
     * @var Collection<int, Acteur>
     */
    #[ORM\OneToMany(targetEntity: Acteur::class, mappedBy: 'acteurFilm')]
    private Collection $id_acteur;

    public function __construct()
    {
        $this->id_film = new ArrayCollection();
        $this->id_acteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getIdFilm(): Collection
    {
        return $this->id_film;
    }

    public function addIdFilm(Film $idFilm): static
    {
        if (!$this->id_film->contains($idFilm)) {
            $this->id_film->add($idFilm);
            $idFilm->setActeurFilm($this);
        }

        return $this;
    }

    public function removeIdFilm(Film $idFilm): static
    {
        if ($this->id_film->removeElement($idFilm)) {
            // set the owning side to null (unless already changed)
            if ($idFilm->getActeurFilm() === $this) {
                $idFilm->setActeurFilm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Acteur>
     */
    public function getIdActeur(): Collection
    {
        return $this->id_acteur;
    }

    public function addIdActeur(Acteur $idActeur): static
    {
        if (!$this->id_acteur->contains($idActeur)) {
            $this->id_acteur->add($idActeur);
            $idActeur->setActeurFilm($this);
        }

        return $this;
    }

    public function removeIdActeur(Acteur $idActeur): static
    {
        if ($this->id_acteur->removeElement($idActeur)) {
            // set the owning side to null (unless already changed)
            if ($idActeur->getActeurFilm() === $this) {
                $idActeur->setActeurFilm(null);
            }
        }

        return $this;
    }
}
