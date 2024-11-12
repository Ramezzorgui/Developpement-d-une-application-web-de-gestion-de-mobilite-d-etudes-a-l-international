<?php

namespace App\Controller;

use App\Entity\Postulation;
use App\Entity\Offres;
use App\Entity\Resultat;
use App\Form\PostulationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostulationController extends AbstractController
{
    #[Route('/postulation', name: 'app_postulation_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager->getRepository(Offres::class)->findAll();
        
        $postulationsByOffre = [];
        foreach ($offres as $offre) {
            $postulationsByOffre[$offre->getId()] = $entityManager->getRepository(Postulation::class)
                ->findBy(['offre' => $offre], ['score' => 'DESC']);
        }

        return $this->render('postulation/index.html.twig', [
            'postulationsByOffre' => $postulationsByOffre,
            'offres' => $offres,
        ]);
    }

    #[Route('/postulation/{id}', name: 'app_postulation_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $postulation = $entityManager->getRepository(Postulation::class)->find($id);

        if (!$postulation) {
            throw new NotFoundHttpException('Postulation not found');
        }

        return $this->render('postulation/show.html.twig', [
            'postulation' => $postulation,
        ]);
    }

    #[Route('/submit-results/{id}', name: 'app_submit_results', methods: ['POST'])]
public function submitResults(int $id, EntityManagerInterface $entityManager): Response
{
    $offer = $entityManager->getRepository(Offres::class)->find($id);
    if (!$offer) {
        throw $this->createNotFoundException('Offer not found');
    }

    $postulations = $entityManager->getRepository(Postulation::class)
        ->findBy(['offre' => $offer], ['score' => 'DESC']);

    $user = $this->getUser(); // Récupère l'utilisateur connecté

    if (!$user) {
        throw $this->createAccessDeniedException('You must be logged in to perform this action.');
    }

    foreach ($postulations as $index => $postulation) {
        $resultat = new Resultat();
        $resultat->setScore($postulation->getScore());
        $resultat->setDate(new \DateTime());
        $resultat->setStatus($index < 10 ? 'Admis' : 'Refusé');
        $resultat->setPostulation($postulation);
        $resultat->setUser($user); // Associer l'utilisateur à chaque résultat
        $resultat->setOffres($offer);

        $entityManager->persist($resultat);
    }

    $entityManager->flush();

    return $this->redirectToRoute('resultat_index');
}



    #[Route('/postulation/{id}/edit', name: 'app_postulation_edit', requirements: ['id' => '\d+'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $postulation = $entityManager->getRepository(Postulation::class)->find($id);

        if (!$postulation) {
            throw new NotFoundHttpException('Postulation not found');
        }

        $form = $this->createForm(PostulationType::class, $postulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_postulation_index');
        }

        return $this->render('postulation/edit.html.twig', [
            'postulation' => $postulation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/postulation/new', name: 'app_postulation_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $postulation = new Postulation();
        $form = $this->createForm(PostulationType::class, $postulation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postulation);
            $entityManager->flush();

            return $this->redirectToRoute('app_postulation_index');
        }

        return $this->render('postulation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
