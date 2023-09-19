<?php

namespace App\Controller\Admin;


use App\Entity\Affaire;
use App\Form\AffaireType;
use App\Form\AffaireFilterType;
use App\Repository\AffaireRepository;
use App\Repository\UserRepository;
use App\Repository\SectionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use App\Entity\Section;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Service\SessionManagementService;



#[Route('/admin/article')]
class AdminArticleController extends AbstractController

{

    

    #[Route('/', name: 'app_admin_article_index', methods: ['GET', 'POST'])]
public function index(Request $request, AffaireRepository $affaireRepository, Security $security): Response
{

    //vérification pour s'assurer qu'une session est active

    if (!$this->isGranted('ROLE_USER')) {
        throw new AccessDeniedException('La session a expiré.');
    }

    

    $user = $security->getUser();
    $role = $user->getRoles()[0]; // recuperer le premier role de l'user 
    
    $form = $this->createForm(AffaireFilterType::class, null, ['role' => $role]);
    $form->handleRequest($request);
    $search = $request->query->get('search');

    if ($form->isSubmitted() && $form->isValid()) {
        if ($request->request->has('reset_filter')) {  // Check if reset button was pressed
            return $this->redirectToRoute('app_admin_article_index'); // Redirect to the same route without filters
        }
        
        $data = $form->getData();

        if ($role == 'ROLE_USER') {
            $affaires = $affaireRepository->filterAffaires(
                $user,
                null,
                $data['compte_c6'],
                $data['search'] ?? null,
                $data['statut'] ?? null  
            );
        } else {
            $userFilter = $data['user'];
            $sectionFilter = $data['section'];
            $affaires = $affaireRepository->filterAffaires(
                $userFilter,
                $sectionFilter,
                $data['compte_c6'],
                $data['search'] ?? null,
                $data['statut'] ?? null  
            );
        }
    } else {
        if ($search) {
            if ($this->isGranted('ROLE_USER')) {
                $affaires = $affaireRepository->findBySearch($search, $user);
            } else {
                $affaires = $affaireRepository->findBySearch($search);
            }
        }else {
            if ($this->isGranted('ROLE_ADMIN')) {
                $affaires = $affaireRepository->findAll();
            } elseif ($this->isGranted('ROLE_RESPONSABLE')) {
                // Si le responsable est connecté, récupérez seulement les affaires de sa section
               // $section = $user->getSection();  // Assurez-vous que la méthode getSection() existe pour récupérer la section de l'utilisateur.
                $affaires = $affaireRepository->findAll();
            } else {
                $affaires = $affaireRepository->findByUser($user);
            }
        }
    }


    return $this->render('admin_article/index.html.twig', [
        'affaires' => $affaires,
        'form' => $form->createView(),
        'controller_name' => 'LookupController'
    ]);
}



    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireRepository $affaireRepository, Security $security): Response
    // Gestion des roles pour la creation des affaires
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_RESPONSABLE')) {
            throw new AccessDeniedException('Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
    }
    
    {
        $affaire = new Affaire();
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $affaireRepository->save($affaire, true);

                return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('admin_article/new.html.twig', [
                'affaire' => $affaire,
                'form' => $form,
            ]);
    }
}

    #[Route('/{id}', name: 'app_admin_article_show', methods: ['GET'])]
    public function show(Affaire $affaire): Response
    {
       return $this->render('admin_article/show.html.twig', [
        'affaire' => $affaire,
    ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affaireRepository->save($affaire, true);

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_article/edit.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_delete', methods: ['POST'])]
    public function delete(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affaire->getId(), $request->request->get('_token'))) {
            $affaireRepository->remove($affaire, true);
        }

        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }
}

