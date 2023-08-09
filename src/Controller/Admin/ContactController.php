<?php

namespace App\Controller\Admin;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Assurez-vous que les namespaces sont correctement définis ici

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->get('email')->getData();
            $sujet = $form->get('sujet')->getData();
            $content = $form->get('content')->getData();

            $email = (new Email())
                ->from($address)
                ->to('yousseflamrani2001@gmail.com')
                ->subject($sujet)
                ->text($content);

            $mailer->send($email);

            return $this->redirectToRoute('app_success_contact'); 
        }

        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form,
        ]);
    }
     #[Route('/success/contact', name: 'app_success_contact')]
     public function success(): Response
     {
         return $this->render('success_contact/index.html.twig', [
             'controller_name' => 'SuccessContactController',
         ]);
     }




    
}

