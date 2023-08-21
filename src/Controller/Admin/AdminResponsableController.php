<?php

namespace App\Controller\Admin;
use App\Entity\Section;
use App\Entity\Responsable;
use App\Form\ResponsableType;
use App\Repository\ResponsableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin/responsable')]
class AdminResponsableController extends AbstractController
{
    #[Route('/', name: 'app_admin_responsable_index', methods: ['GET'])]
    public function index(ResponsableRepository $responsableRepository): Response
 //GESTION DES ROLES POUR L'AFFICHAGE DES RESPONSABLES ON UTILISANT AccessDeniedException
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
        }


    {
        return $this->render('admin_responsable/index.html.twig', [
            'responsables' => $responsableRepository->findAll(),
        ]);
    }
}

    #[Route('/new', name: 'app_admin_responsable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ResponsableRepository $responsableRepository): Response
    {
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responsableRepository->save($responsable, true);

            return $this->redirectToRoute('app_admin_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_responsable/new.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_responsable_show', methods: ['GET'])]
    public function show(Responsable $responsable): Response
    {
        return $this->render('admin_responsable/show.html.twig', [
            'responsable' => $responsable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_responsable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Responsable $responsable, ResponsableRepository $responsableRepository): Response
    {
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responsableRepository->save($responsable, true);

            return $this->redirectToRoute('app_admin_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_responsable/edit.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_responsable_delete', methods: ['POST'])]
    public function delete(Request $request, Responsable $responsable, ResponsableRepository $responsableRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responsable->getId(), $request->request->get('_token'))) {
            $responsableRepository->remove($responsable, true);
        }

        return $this->redirectToRoute('app_admin_responsable_index', [], Response::HTTP_SEE_OTHER);
    }
}
