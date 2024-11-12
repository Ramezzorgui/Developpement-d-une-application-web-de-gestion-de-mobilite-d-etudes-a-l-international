<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NotificationRepository;

class EspritController extends AbstractController
{
    #[Route("/esprit", name: "esprit_index")]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $user = $this->getUser(); // Get the currently logged-in user
    
        if (!$user) {
            throw $this->createAccessDeniedException('You need to be logged in to see notifications.');
        }else{
            // Fetch notifications for the logged-in user
            $notifs = $notificationRepository->findAll();
        }
    
        

        return $this->render('esprit/page1.html.twig', [
            'notifs' => $notifs,
        ]);
    }
    
    #[Route("/apropos", name: "apropos")]
    public function index2(): Response
    {
        return $this->render('esprit/apropos.html.twig');
    }
}
