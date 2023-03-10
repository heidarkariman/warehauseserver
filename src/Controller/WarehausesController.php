<?php

namespace App\Controller;

use App\Entity\Warehauses;
use App\Form\WarehausesType;
use App\Repository\WarehausesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/warehauses')]
class WarehausesController extends AbstractController
{
    #[Route('/', name: 'app_warehauses_index', methods: ['GET'])]
    public function index(WarehausesRepository $warehausesRepository): Response
    {
        return $this->render('warehauses/index.html.twig', [
            'warehauses' => $warehausesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_warehauses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WarehausesRepository $warehausesRepository): Response
    {
        $warehause = new Warehauses();
        $form = $this->createForm(WarehausesType::class, $warehause);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $warehausesRepository->save($warehause, true);

            return $this->redirectToRoute('app_warehauses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('warehauses/new.html.twig', [
            'warehause' => $warehause,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_warehauses_show', methods: ['GET'])]
    public function show(Warehauses $warehause): Response
    {
        return $this->render('warehauses/show.html.twig', [
            'warehause' => $warehause,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_warehauses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Warehauses $warehause, WarehausesRepository $warehausesRepository): Response
    {
        $form = $this->createForm(WarehausesType::class, $warehause);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $warehausesRepository->save($warehause, true);

            return $this->redirectToRoute('app_warehauses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('warehauses/edit.html.twig', [
            'warehause' => $warehause,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_warehauses_delete', methods: ['POST'])]
    public function delete(Request $request, Warehauses $warehause, WarehausesRepository $warehausesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$warehause->getId(), $request->request->get('_token'))) {
            $warehausesRepository->remove($warehause, true);
        }

        return $this->redirectToRoute('app_warehauses_index', [], Response::HTTP_SEE_OTHER);
    }
}
