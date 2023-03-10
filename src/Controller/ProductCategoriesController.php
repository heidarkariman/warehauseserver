<?php

namespace App\Controller;

use App\Entity\ProductCategories;
use App\Form\ProductCategoriesType;
use App\Repository\ProductCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product/categories')]
class ProductCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_product_categories_index', methods: ['GET'])]
    public function index(ProductCategoriesRepository $productCategoriesRepository): Response
    {
        return $this->render('product_categories/index.html.twig', [
            'product_categories' => $productCategoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductCategoriesRepository $productCategoriesRepository): Response
    {
        $productCategory = new ProductCategories();
        $form = $this->createForm(ProductCategoriesType::class, $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productCategoriesRepository->save($productCategory, true);

            return $this->redirectToRoute('app_product_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_categories/new.html.twig', [
            'product_category' => $productCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_categories_show', methods: ['GET'])]
    public function show(ProductCategories $productCategory): Response
    {
        return $this->render('product_categories/show.html.twig', [
            'product_category' => $productCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProductCategories $productCategory, ProductCategoriesRepository $productCategoriesRepository): Response
    {
        $form = $this->createForm(ProductCategoriesType::class, $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productCategoriesRepository->save($productCategory, true);

            return $this->redirectToRoute('app_product_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_categories/edit.html.twig', [
            'product_category' => $productCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_categories_delete', methods: ['POST'])]
    public function delete(Request $request, ProductCategories $productCategory, ProductCategoriesRepository $productCategoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productCategory->getId(), $request->request->get('_token'))) {
            $productCategoriesRepository->remove($productCategory, true);
        }

        return $this->redirectToRoute('app_product_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
