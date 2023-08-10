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

#[Route('/admin/article')]
class AdminArticleController extends AbstractController
{
    #[Route('/', name: 'app_admin_article_index', methods: ['GET', 'POST'])]
    public function index(Request $request, AffaireRepository $affaireRepository): Response
    {
        $form = $this->createForm(AffaireFilterType::class);
        $form->handleRequest($request);
        $search = $request->query->get('search');

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Filter using the combined method
            $affaires = $affaireRepository->filterAffaires($data['user'], $data['section'], $data['compte_c6'], $data['search'] ?? null);
        } else {
            if ($search) {
                $affaires = $affaireRepository->findBySearch($search);
            } else {
                $affaires = $affaireRepository->findAll();
            }
        }

        return $this->render('admin_article/index.html.twig', [
            'affaires' => $affaires,
            'form' => $form->createView(),
            'controller_name' => 'LookupController'
        ]);
    }







    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireRepository $affaireRepository): Response
    
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

