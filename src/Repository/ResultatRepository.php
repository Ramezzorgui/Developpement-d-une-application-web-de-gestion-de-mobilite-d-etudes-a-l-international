<?php

namespace App\Repository;

use App\Entity\Resultat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ResultatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resultat::class);
    }

    public function findByOffreSortedByScore($offreId)
    {
        return $this->createQueryBuilder('r')
            ->where('r.offres = :offre')
            ->setParameter('offre', $offreId)
            ->orderBy('r.score', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
