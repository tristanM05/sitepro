<?php

namespace App\Controller\user;

use App\Entity\Contact;
use App\Entity\Projets;
use App\Form\ContactType;
use App\Repository\ProjetsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $req, MailerInterface $mailer, ProjetsRepository $repo)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($req);

        $projet = $repo->findAll();
        // $projet2 = $repo->findBy(['id' => $id]);

        $messageContact = $contact->getMessage();
        $mail = $contact->getMail();

        if($form->isSubmitted() && $form->isValid()){
            $message = (new TemplatedEmail())
                ->from($mail)
                ->to('marest.tristan@gmail.com')
                ->subject('Message utilisateur')
                ->html("<p>
                Email: $mail<br>
                Message: $messageContact
                </p>");

                $mailer->send($message);

            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute("home");
        }

        return $this->render('home.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
            // 'projet2' => $projet2
        ]);

    }

    /**
     *@Route("/projet/{id}", name="showProjet")
     * @return void
     */
    public function showProject(ProjetsRepository $repo, $id){
        $projet2 = $repo->findBy(['id' => $id]);
        return $this->json([
            'projet2' => $projet2
        ],200);
    }
}
