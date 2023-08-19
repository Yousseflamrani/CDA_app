<?php

namespace App\Controller\Admin;


use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin/section')]
class AdminSectionController extends AbstractController
{
    #[Route('/', name: 'app_admin_section_index', methods: ['GET'])]
    public function index(SectionRepository $sectionRepository): Response
    //GESTION DES ROLES POUR L'AFFICHAGE DES SECTION ON UTILISANT AccessDeniedException
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
        }
    
       
    
    {
        return $this->render('admin_section/index.html.twig', [
            'sections' => $sectionRepository->findAll(),
        ]);
    }
}

    #[Route('/new', name: 'app_admin_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SectionRepository $sectionRepository): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->save($section, true);

            return $this->redirectToRoute('app_admin_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_section/new.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_section_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        return $this->render('admin_section/show.html.twig', [
            'section' => $section,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->save($section, true);

            return $this->redirectToRoute('app_admin_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_section/edit.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_section_delete', methods: ['POST'])]
    public function delete(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            $sectionRepository->remove($section, true);
        }

        return $this->redirectToRoute('app_admin_section_index', [], Response::HTTP_SEE_OTHER);
    }
}
