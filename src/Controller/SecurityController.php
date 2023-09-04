<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
    $user = $this->getUser();
        
    if ($user) {
        // Vérifie si l'utilisateur est autorisé à se connecter
        if (false === $this->authChecker->isGranted('IS_EMAIL_VERIFIED')) {
            // Redirigez vers une route d'erreur ou affichez un message d'erreur
            $this->addFlash('error', 'Veuillez vérifier votre adresse e-mail avant de vous connecter.');
            return $this->redirectToRoute('app_register'); // Ou une autre route de votre choix
        }
        
        // Autres vérifications ou logiques que vous pourriez avoir
    }

    // Récupérez l'erreur de connexion, le cas échéant
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
}


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
