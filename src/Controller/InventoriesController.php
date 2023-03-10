<?php

namespace App\Controller;

use App\Entity\Inventories;
use App\Form\InventoriesType;
use App\Repository\InventoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inventories')]
class InventoriesController extends AbstractController
{
    #[Route('/', name: 'app_inventories_index', methods: ['GET'])]
    public function index(InventoriesRepository $inventoriesRepository): Response
    {
        return $this->render('inventories/index.html.twig', [
            'inventories' => $inventoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inventories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InventoriesRepository $inventoriesRepository): Response
    {
        $inventory = new Inventories();
        $form = $this->createForm(InventoriesType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventoriesRepository->save($inventory, true);

            return $this->redirectToRoute('app_inventories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventories/new.html.twig', [
            'inventory' => $inventory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventories_show', methods: ['GET'])]
    public function show(Inventories $inventory): Response
    {
        return $this->render('inventories/show.html.twig', [
            'inventory' => $inventory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inventories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inventories $inventory, InventoriesRepository $inventoriesRepository): Response
    {
        $form = $this->createForm(InventoriesType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventoriesRepository->save($inventory, true);

            return $this->redirectToRoute('app_inventories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventories/edit.html.twig', [
            'inventory' => $inventory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventories_delete', methods: ['POST'])]
    public function delete(Request $request, Inventories $inventory, InventoriesRepository $inventoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventory->getId(), $request->request->get('_token'))) {
            $inventoriesRepository->remove($inventory, true);
        }

        return $this->redirectToRoute('app_inventories_index', [], Response::HTTP_SEE_OTHER);
    }
}
