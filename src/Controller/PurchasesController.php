<?php

namespace App\Controller;

use App\Entity\Purchases;
use App\Form\PurchasesType;
use App\Repository\PurchasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/purchases')]
class PurchasesController extends AbstractController
{
    #[Route('/', name: 'app_purchases_index', methods: ['GET'])]
    public function index(PurchasesRepository $purchasesRepository): Response
    {
        return $this->render('purchases/index.html.twig', [
            'purchases' => $purchasesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_purchases_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PurchasesRepository $purchasesRepository): Response
    {
        $purchase = new Purchases();
        $form = $this->createForm(PurchasesType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $purchasesRepository->save($purchase, true);

            return $this->redirectToRoute('app_purchases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purchases/new.html.twig', [
            'purchase' => $purchase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purchases_show', methods: ['GET'])]
    public function show(Purchases $purchase): Response
    {
        return $this->render('purchases/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_purchases_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Purchases $purchase, PurchasesRepository $purchasesRepository): Response
    {
        $form = $this->createForm(PurchasesType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $purchasesRepository->save($purchase, true);

            return $this->redirectToRoute('app_purchases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purchases/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purchases_delete', methods: ['POST'])]
    public function delete(Request $request, Purchases $purchase, PurchasesRepository $purchasesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchase->getId(), $request->request->get('_token'))) {
            $purchasesRepository->remove($purchase, true);
        }

        return $this->redirectToRoute('app_purchases_index', [], Response::HTTP_SEE_OTHER);
    }
}
