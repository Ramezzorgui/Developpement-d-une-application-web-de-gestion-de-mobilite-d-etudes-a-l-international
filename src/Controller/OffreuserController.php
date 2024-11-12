<?php

namespace App\Controller;

use App\Entity\Postulation;
use App\Entity\Notification; // Import the Notification entity
use App\Form\PostulationType;
use App\Repository\OffresRepository;
use App\Repository\UserRepository; // Import the User repository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreuserController extends AbstractController
{
    #[Route('/offreuser', name: 'user_offreuser_index')]
    public function index(OffresRepository $offresRepository): Response
    {
        $offres = $offresRepository->findAll();
        return $this->render('offreuser/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/offreuser/{id}', name: 'user_offreuser_show')]
    public function show(int $id, OffresRepository $offresRepository): Response
    {
        $offre = $offresRepository->find($id);

        if (!$offre) {
            throw $this->createNotFoundException('The offer does not exist');
        }

        return $this->render('offreuser/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/postuler/{id}', name: 'user_postulation_postuler')]
    public function postuler(int $id, Request $request, OffresRepository $offresRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $offre = $offresRepository->find($id);

        if (!$offre) {
            throw $this->createNotFoundException('The offer does not exist');
        }

        $postulation = new Postulation();
        $form = $this->createForm(PostulationType::class, $postulation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Set the related offer for the postulation
            $postulation->setOffre($offre); // Assuming you have a method to set the offer

            // Persist the postulation
            $entityManager->persist($postulation);
            $entityManager->flush();

            // Notify all users about the new offer
            $users = $userRepository->findAll();
            foreach ($users as $user) {
                $notification = new Notification();
                $notification->setUser($user);
                $notification->setMessage('A new offer has been published: ' . $offre->getTitle());
                $notification->setOffre($offre);
                $notification->setCreatedAt(new \DateTime()); // Assuming you have a createdAt property

                $entityManager->persist($notification);
            }

            $entityManager->flush(); // Flush all notifications to the database

            return $this->redirectToRoute('user_offreuser_index');
        }

        return $this->render('postulation/postuler.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
