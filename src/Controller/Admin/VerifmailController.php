<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerifmailController extends AbstractController
{
    #[Route('/verifmail', name: 'app_verifmail')]
    public function index(): Response
    {
        return $this->render('verifmail/index.html.twig', [
            'controller_name' => 'VerifmailController',
        ]);
    }
}
