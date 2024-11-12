<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatRepository::class)]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Postulation::class, inversedBy: 'resultats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Postulation $postulation = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Offres::class, inversedBy: 'resultats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offres $offres = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $score = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    // Getters and Setters
    #[ORM\Column(type: Types::STRING)]
private ?string $status = null;

public function getStatus(): ?string
{
    return $this->status;
}

public function setStatus(string $status): static
{
    $this->status = $status;
    return $this;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostulation(): ?Postulation
    {
        return $this->postulation;
    }

    public function setPostulation(?Postulation $postulation): static
    {
        $this->postulation = $postulation;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getOffres(): ?Offres
    {
        return $this->offres;
    }

    public function setOffres(?Offres $offres): static
    {
        $this->offres = $offres;
        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): static
    {
        $this->score = $score;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }
}
