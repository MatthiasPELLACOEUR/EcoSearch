<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
    */
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // On crée le mail
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('matthias.p69@gmail.com')
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'mail' => $contact->get('email')->getData(), 
                    'subject' => $contact->get('subject')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // On envoie le mail
            $mailer->send($email);

            // On confirme et on redirige
            $this->addFlash('message', 'Votre e-mail a bien été envoyé.');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
