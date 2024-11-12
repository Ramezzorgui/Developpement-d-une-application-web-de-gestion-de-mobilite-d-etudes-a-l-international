<?php

namespace App\Controller;

use App\Entity\Resultat;
use App\Entity\Offres;
use App\Repository\ResultatUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user/resultat', name: 'user_resultat_')]
class ResultatUserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function listClassroom(ResultatUserRepository $repo)
    {   
        $resultat_user = $repo->findAll();
        return $this->render("resultat_user/show.html.twig",["list" => $resultat_user]);
    }

    
}
