<?php

namespace App\Repository;

use App\Entity\Postulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Postulation>
 *
 * @method Postulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postulation[]    findAll()
 * @method Postulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postulation::class);
    }

    /**
     * @return Postulation[] Returns an array of Postulation objects sorted by score for a specific offer
     */
    public function findAllSortedByScore(int $offerId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.offre = :offerId')
            ->setParameter('offerId', $offerId)
            ->orderBy('p.score', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
