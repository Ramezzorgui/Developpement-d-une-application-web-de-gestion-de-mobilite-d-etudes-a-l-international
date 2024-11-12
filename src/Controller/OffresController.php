<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Entity\Notification;
use App\Form\OffresType;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/offres')]
class OffresController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(EntityManagerInterface $entityManager, Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    #[Route('/', name: 'app_offres_index', methods: ['GET'])]
    public function index(OffresRepository $offresRepository): Response
    {
        return $this->render('offres/index.html.twig', [
            'offres' => $offresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offres_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $offre = new Offres();
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($offre);
            $this->entityManager->flush(); // Ensure the offre is persisted before creating the notification
    
            // Retrieve the currently logged-in user
            $user = $this->security->getUser();
    
            if ($user) {
                // Create notification
                $notification = new Notification();
                $notification->setUser($user);
                $notification->setMessage('A new offre has been published.');
                $notification->setOffre($offre);
                $notification->setCreatedAt(new \DateTime());
                $notification->setType('offer');
                $notification->setLink($this->urlGenerator->generate('app_offres_show', ['id' => $offre->getId()]));
    
                $this->entityManager->persist($notification);
                $this->entityManager->flush();
    
                $this->addFlash('success', 'Offre and notification saved successfully.');
            } else {
                $this->addFlash('error', 'Failed to create notification: No user found.');
            }
    
            return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('offres/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_offres_show', methods: ['GET'])]
    public function show(Offres $offre): Response
    {
        // Fetch postulations for the specific offer
        $postulations = $offre->getPostulations();

        return $this->render('resultat/index.html.twig', [
            'offre' => $offre,
            'postulations' => $postulations,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offres $offre): Response
    {
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offres/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_offres_delete', methods: ['POST'])]
    public function delete(Request $request, Offres $offre): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offre->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($offre);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
    }
}
