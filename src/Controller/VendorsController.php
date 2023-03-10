<?php

namespace App\Controller;

use App\Entity\Vendors;
use App\Form\VendorsType;
use App\Repository\VendorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendors')]
class VendorsController extends AbstractController
{
    #[Route('/', name: 'app_vendors_index', methods: ['GET'])]
    public function index(VendorsRepository $vendorsRepository): Response
    {
        return $this->render('vendors/index.html.twig', [
            'vendors' => $vendorsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vendors_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VendorsRepository $vendorsRepository): Response
    {
        $vendor = new Vendors();
        $form = $this->createForm(VendorsType::class, $vendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorsRepository->save($vendor, true);

            return $this->redirectToRoute('app_vendors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendors/new.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vendors_show', methods: ['GET'])]
    public function show(Vendors $vendor): Response
    {
        return $this->render('vendors/show.html.twig', [
            'vendor' => $vendor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vendors_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vendors $vendor, VendorsRepository $vendorsRepository): Response
    {
        $form = $this->createForm(VendorsType::class, $vendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorsRepository->save($vendor, true);

            return $this->redirectToRoute('app_vendors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendors/edit.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vendors_delete', methods: ['POST'])]
    public function delete(Request $request, Vendors $vendor, VendorsRepository $vendorsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vendor->getId(), $request->request->get('_token'))) {
            $vendorsRepository->remove($vendor, true);
        }

        return $this->redirectToRoute('app_vendors_index', [], Response::HTTP_SEE_OTHER);
    }
}
