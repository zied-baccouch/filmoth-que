<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Film>
     */
    #[ORM\OneToMany(targetEntity: Film::class, mappedBy: 'categorie')]
    private Collection $id_categorie;

    #[ORM\Column(length: 255)]
    private ?string $design_categorie = null;

    public function __construct()
    {
        $this->id_categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getIdCategorie(): Collection
    {
        return $this->id_categorie;
    }

    public function addIdCategorie(Film $idCategorie): static
    {
        if (!$this->id_categorie->contains($idCategorie)) {
            $this->id_categorie->add($idCategorie);
            $idCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeIdCategorie(Film $idCategorie): static
    {
        if ($this->id_categorie->removeElement($idCategorie)) {
            // set the owning side to null (unless already changed)
            if ($idCategorie->getCategorie() === $this) {
                $idCategorie->setCategorie(null);
            }
        }

        return $this;
    }

    public function getDesignCategorie(): ?string
    {
        return $this->design_categorie;
    }

    public function setDesignCategorie(string $design_categorie): static
    {
        $this->design_categorie = $design_categorie;

        return $this;
    }
}
