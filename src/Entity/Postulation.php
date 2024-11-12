<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostulationRepository;
use App\Entity\Offres;
use App\Entity\User;


#[ORM\Entity(repositoryClass: PostulationRepository::class)]
class Postulation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(type: 'float')]
    private ?float $moy1 = null;

    #[ORM\Column(type: 'float')]
    private ?float $moy2 = null;

    #[ORM\Column(type: 'float')]
    private ?float $moy3 = null;

    #[ORM\Column(type: 'float')]
    private ?float $score = null;

    #[ORM\Column(length: 255)]
    private ?string $etude = null;

    #[ORM\Column(length: 255)]
    private ?string $relevenote = null;

    #[ORM\ManyToOne(targetEntity: Offres::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offres $offre = null;

    private ?User $user = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;
        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function getMoy1(): ?float
    {
        return $this->moy1;
    }

    public function setMoy1(float $moy1): static
    {
        $this->moy1 = $moy1;
        $this->calculateScore();
        return $this;
    }

    public function getMoy2(): ?float
    {
        return $this->moy2;
    }

    public function setMoy2(float $moy2): static
    {
        $this->moy2 = $moy2;
        $this->calculateScore();
        return $this;
    }

    public function getMoy3(): ?float
    {
        return $this->moy3;
    }

    public function setMoy3(float $moy3): static
    {
        $this->moy3 = $moy3;
        $this->calculateScore();
        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    private function calculateScore(): void
    {
        if ($this->moy1 !== null && $this->moy2 !== null && $this->moy3 !== null) {
            $this->score = ($this->moy1 + $this->moy2 + $this->moy3) / 3;
        }
    }

    public function getEtude(): ?string
    {
        return $this->etude;
    }

    public function setEtude(string $etude): static
    {
        $this->etude = $etude;
        return $this;
    }

    public function getRelevenote(): ?string
    {
        return $this->relevenote;
    }

    public function setRelevenote(string $relevenote): static
    {
        $this->relevenote = $relevenote;
        return $this;
    }

    public function getOffre(): ?Offres
    {
        return $this->offre;
    }

    public function setOffre(?Offres $offre): static
    {
        $this->offre = $offre;
        return $this;
    }
}
