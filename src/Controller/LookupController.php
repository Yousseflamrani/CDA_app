<?php

namespace App\Controller;
use App\Repository\AffaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





class LookupController extends AbstractController
{
    #[Route('/lookup', name: 'app_lookup')] 
    public function index(Request $request , AffaireRepository $affaireRepository): Response
    {
      $search= $request->query->get('search');
      $aff= $affaireRepository->findBySearch($search);

      return $this->render('lookup/index.html.twig',[
          'controller_name'=> 'LookupController',
          'affaires'=>$aff,
      ]);

    }

   
}