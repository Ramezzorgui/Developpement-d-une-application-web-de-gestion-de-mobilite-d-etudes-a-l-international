<?php

namespace App\Entity;

use App\Repository\ResultatUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatUserRepository::class)]
class ResultatUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'resultatUsers')]
    private ?Offres $res = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Postulation $re = null;

    #[ORM\ManyToOne(inversedBy: 'resultatUsers')]
    private ?User $ress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getRes(): ?Offres
    {
        return $this->res;
    }

    public function setRes(?Offres $res): static
    {
        $this->res = $res;

        return $this;
    }

    public function getRe(): ?Postulation
    {
        return $this->re;
    }

    public function setRe(?Postulation $re): static
    {
        $this->re = $re;

        return $this;
    }

    public function getRess(): ?User
    {
        return $this->ress;
    }

    public function setRess(?User $ress): static
    {
        $this->ress = $ress;

        return $this;
    }
}
