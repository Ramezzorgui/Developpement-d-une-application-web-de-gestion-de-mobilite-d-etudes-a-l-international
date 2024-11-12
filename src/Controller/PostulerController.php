<?php

namespace App\Controller;

use App\Entity\Postulation;
use App\Form\PostulationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostulerController extends AbstractController
{
    #[Route("/postuler", name: "postulation")]
    public function postulation(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a new instance of the Postulation entity
        $postulation = new Postulation();

        // Create the form
        $form = $this->createForm(PostulationType::class, $postulation);

        // Handle the request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the data in the database
            $entityManager->persist($postulation);
            $entityManager->flush();

            // Add flash message
            $this->addFlash('success', 'Your application has been successfully submitted.');

            // Redirect to the success page
            return $this->redirectToRoute('postulation_success');
        }

        // Render the form view
        return $this->render('postulation/postuler.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/postulation/success", name: "postulation_success")]
    public function postulationSuccess(): Response
    {
        return new Response('Your application has been successfully submitted.');
    }
}
