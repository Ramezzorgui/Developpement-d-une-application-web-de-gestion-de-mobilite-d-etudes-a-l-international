<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MailingController extends AbstractController
{
    #[Route('/send-emails-page', name: 'app_send_emails_page', methods: ['GET'])]
    public function showSendEmailsPage(): Response
    {
        return $this->render('mailer/sendEmails.html.twig');
    }

    #[Route('/send-emails', name: 'app_send_emails', methods: ['POST'])]
    public function sendEmailsTo4emeClass(MailerInterface $mailer, UserRepository $userRepository): RedirectResponse
    {
        // Retrieve students from the "4ème" class
        $users = $userRepository->findBy(['Classe' => '4ème']);
    
        // Check if there are students
        if (!$users) {
            $this->addFlash('info', 'No students found in 4ème class.');
            return $this->redirectToRoute('app_send_emails_page'); // Adjust route as needed
        }
    
        foreach ($users as $user) {
            $email = (new Email())
                ->from('ramezzorgui74@gmail.com')
                ->to($user->getEmail())
                ->subject('Information for 4ème Class Students')
                ->html('
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Email</title>
                        <style>
                            .deadline {
                                color: red;
                                font-weight: bold;
                            }
                            .bold {
                                font-weight: bold;
                            }
                            .link {
                                color: blue;
                                text-decoration: underline;
                            }
                        </style>
                    </head>
                    <body>
                        <p>Bonjour ' . $user->getNom() . ',</p>
                        <p>
                            Dans le cadre de notre nouveau partenariat avec <a href="https://www.emsi.ma" class="link">EMSI (https://www.emsi.ma)</a>,
                            nos étudiants actuellement en 4ème (Info, Télécom) pourraient postuler pour une mobilité (semestre d\'échange, le dernier semestre, S9). 
                            Merci de consulter le document joint afin de déposer votre candidature. La date limite de dépôt des candidatures : 
                            <span class="deadline">lundi 26 Juin 2023 à midi, délai de rigueur</span>.
                        </p>
                        <ul>
                            <li> 
                                Lien du formulaire de candidature à utiliser <span class="bold">obligatoirement</span>: 
                                <a href="http://127.0.0.1:8000/postulation/new" class="link">lien</a>
                            </li>
                            <li> 
                                <a href="https://www.emsi.ma/ingenierie-informatique-et-reseaux" class="link">https://www.emsi.ma/ingenierie-informatique-et-reseaux</a>
                            </li>
                            <li> 
                                Ceux qui seront sélectionnés payeront les frais d\'inscription à Esprit (5ème année).
                            </li>
                        </ul>
                        <p>
                            Une pré-sélection se fera au niveau d\'Esprit.<br>
                            Comme vous le savez, le Maroc s\'est beaucoup développé avec un tissu industriel très garni.<br>
                            Bon courage.
                        </p>
                    </body>
                    </html>
                ');
        
            // Send the email using your preferred email sending method
            // $mailer->send($email);
        
        
    
            try {
                $mailer->send($email);
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                $this->addFlash('error', 'Failed to send email to ' . $user->getEmail());
            }
        }
    
        $this->addFlash('success', 'Emails have been sent to all 4ème class students.');
        return $this->redirectToRoute('app_send_emails_page'); // Adjust route as needed
    }
}
