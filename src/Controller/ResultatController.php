<?php

namespace App\Controller;

use App\Entity\Resultat;
use App\Entity\ResultatUser;
use App\Entity\User;

use App\Entity\Offres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resultat', name: 'resultat_')]
class ResultatController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager->getRepository(Offres::class)->findAll();
        $resultatsByOffre = [];

        foreach ($offres as $offre) {
            $resultatsByOffre[$offre->getId()] = $entityManager->getRepository(Resultat::class)
                ->findBy(['offres' => $offre], ['score' => 'DESC']);
        }

        return $this->render('resultat/index.html.twig', [
            'resultatsByOffre' => $resultatsByOffre,
            'offres' => $offres,
        ]);
    }

    #[Route('/submit-results/{id}', name: 'submit_results', methods: ['POST'])]
    public function submitResults(int $id, EntityManagerInterface $entityManager): Response
    {
        $offre = $entityManager->getRepository(Offres::class)->find($id);
        if (!$offre) {
            throw $this->createNotFoundException('Offre not found');
        }
    
        $postulations = $entityManager->getRepository(Resultat::class)
            ->findBy(['offres' => $offre], ['score' => 'DESC']);
    
        // Clear previous results
        $entityManager->getRepository(Resultat::class)
            ->createQueryBuilder('r')
            ->delete()
            ->where('r.offres = :offre')
            ->setParameter('offre', $offre)
            ->getQuery()
            ->execute();
    
        // Create new results with status
        foreach ($postulations as $index => $resultat) {
            $status = $index < 10 ? 'Accepted' : 'Refused';
            $resultat->setStatus($status);
            $entityManager->persist($resultat);
    
            // Enregistrement dans ResultatUser
            $resultatUser = new ResultatUser();
            $resultatUser->setRess($resultat->getUser());
            $resultatUser->setRes($offre);
            $resultatUser->setScore($resultat->getScore());
            $resultatUser->setStatus($status);
            $entityManager->persist($resultatUser);
        }
    
        $entityManager->flush();
    
        return $this->redirectToRoute('resultat_index');
    }

    
  #[Route("/resultat/{id}", name:"app_resultat_show", methods:['GET'])]
public function show(Resultat $resultat): Response
{
    return $this->render('resultat/show.html.twig', [
        'resultat' => $resultat,
    ]);
}
    
    
}
