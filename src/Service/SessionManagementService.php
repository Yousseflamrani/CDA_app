<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SessionManagementService
{
    private $session;
    private $tokenStorage;

    public function __construct(SessionInterface $session, TokenStorageInterface $tokenStorage)
    {
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
    }

    public function checkAndInvalidateSessionIfInactive()
    {
        $lastActivityTime = $this->session->get('last_activity_time');
        $currentTime = time();

        // Durée d'inactivité autorisée avant déconnexion automatique 
        $inactivityTimeout = 20; // 1 heure

        if ($lastActivityTime !== null && ($currentTime - $lastActivityTime) > $inactivityTimeout) {
            // L'utilisateur est inactif depuis plus d'une heure, déconnexion automatique
            $this->tokenStorage->setToken(null); // Déconnexion de l'utilisateur
            $this->session->invalidate(); // Invalider la session
        }

        // Mettre à jour l'heure de la dernière activité
        $this->session->set('last_activity_time', $currentTime);
    }
}
