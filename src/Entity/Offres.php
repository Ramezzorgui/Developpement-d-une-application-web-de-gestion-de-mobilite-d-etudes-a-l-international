<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffresRepository::class)]
class Offres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column(length: 255)]
    private ?string $date = null;

    #[ORM\OneToMany(targetEntity: Resultat::class, mappedBy: 'offres')]
    private Collection $resultats;

    #[ORM\OneToMany(targetEntity: Postulation::class, mappedBy: 'offre')]
    private Collection $postulations;

    #[ORM\OneToMany(targetEntity: ResultatUser::class, mappedBy: 'res')]
    private Collection $resultatUsers;

    public function __construct()
    {
        $this->resultats = new ArrayCollection();
        $this->postulations = new ArrayCollection();
        $this->resultatUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;
        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Collection<int, Resultat>
     */
    public function getResultats(): Collection
    {
        return $this->resultats;
    }

    public function addResultat(Resultat $resultat): static
    {
        if (!$this->resultats->contains($resultat)) {
            $this->resultats->add($resultat);
            $resultat->setOffres($this);
        }
        return $this;
    }

    public function removeResultat(Resultat $resultat): static
    {
        if ($this->resultats->removeElement($resultat)) {
            if ($resultat->getOffres() === $this) {
                $resultat->setOffres(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Postulation>
     */
    public function getPostulations(): Collection
    {
        return $this->postulations;
    }

    public function addPostulation(Postulation $postulation): static
    {
        if (!$this->postulations->contains($postulation)) {
            $this->postulations->add($postulation);
            $postulation->setOffre($this);
        }
        return $this;
    }

    public function removePostulation(Postulation $postulation): static
    {
        if ($this->postulations->removeElement($postulation)) {
            if ($postulation->getOffre() === $this) {
                $postulation->setOffre(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, ResultatUser>
     */
    public function getResultatUsers(): Collection
    {
        return $this->resultatUsers;
    }

    public function addResultatUser(ResultatUser $resultatUser): static
    {
        if (!$this->resultatUsers->contains($resultatUser)) {
            $this->resultatUsers->add($resultatUser);
            $resultatUser->setRes($this);
        }

        return $this;
    }

    public function removeResultatUser(ResultatUser $resultatUser): static
    {
        if ($this->resultatUsers->removeElement($resultatUser)) {
            // set the owning side to null (unless already changed)
            if ($resultatUser->getRes() === $this) {
                $resultatUser->setRes(null);
            }
        }

        return $this;
    }
}
