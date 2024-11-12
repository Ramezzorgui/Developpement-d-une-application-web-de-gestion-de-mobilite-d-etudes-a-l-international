<?php

// src/Controller/NotificationController.php
namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends AbstractController
{
    private $entityManager;

    #[Route('/notifications', name: 'user_notifications')]
    public function getNotifs(UserRepository $userRepository, NotificationRepository $notificationRepository): Response
    {
        $user = $this->getUser(); // Get the currently logged-in user
    
        if (!$user) {
            throw $this->createAccessDeniedException('You need to be logged in to see notifications.');
        }
    
        // Fetch notifications for the logged-in user
        $notifications = $notificationRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);
    
        return $this->render('notifications/page1.html.twig', [
            'notifications' => $notifications,
        ]);
    }
    
}
