<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_categories_index', methods: ['GET'])]
    #[Route('/api', name: 'api_categories_index', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository, Request $request): Response
    {
        $categories = $categoriesRepository->findAll();
        
        if ($request->attributes->get('_route') === 'api_categories_index') {
            $data = [];
            foreach ($categories as $category) {
                $data[] = [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                ];
            }
            return $this->json($data, Response::HTTP_OK);
        }

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'app_categories_new', methods: ['GET', 'POST'])]
    #[Route('/api/new', name: 'api_categories_new', methods: ['POST'])]
    public function new(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $category = new Categories();
        $form = null;
    
        // check if the request is an API request
        if ($request->attributes->get('_route') === 'api_categories_new') {
            // retrieve the name and description parameters from the request
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            
            // set the name and description values on the category object
            $category->setName($name);
            $category->setDescription($description);
        } else {
            // create the form for the category
            $form = $this->createForm(CategoriesType::class, $category);
            $form->handleRequest($request);
        }
                
        if ($form === null || ($form->isSubmitted() && $form->isValid())) {
            $categoriesRepository->save($category, true);
            
            // check if the request is an API request
            if ($request->attributes->get('_route') === 'api_categories_new') {
                return $this->json([
                    'id' => $category->getId(),
                ], Response::HTTP_CREATED);
            }
    
            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_categories_show', methods: ['GET'])]
    #[Route('/api/{id}', name: 'api_categories_show', methods: ['GET'])]
    public function show(Categories $category, Request $request): Response
    {
        if ($request->attributes->get('_route') === 'api_categories_show') {
            $data = [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
            return $this->json($data, Response::HTTP_OK);
        }

        return $this->render('categories/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categories_edit', methods: ['GET', 'POST'])]
    #[Route('/api/{id}/edit', name: 'api_categories_edit', methods: ['PUT'])]
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $form = null;
    
        // check if the request is an API request
        if ($request->attributes->get('_route') === 'api_categories_edit') {

            // get the request content and decode it
        $data = json_decode($request->getContent(), true);
        // retrieve the name and description parameters from the decoded data
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;
        
            // set the name and description values on the category object
            $category->setName($name);
            $category->setDescription($description);
        } else {
            // create the form for the category
            $form = $this->createForm(CategoriesType::class, $category);
            $form->handleRequest($request);
        }
    
        if ($form === null || ($form->isSubmitted() && $form->isValid())) {
            $categoriesRepository->save($category, true);
    
            // check if the request is an API request
            if ($request->attributes->get('_route') === 'api_categories_edit') {
                return $this->json(null, Response::HTTP_NO_CONTENT);
            }
    
            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_categories_delete', methods: ['POST'])]
    #[Route('/api/{id}', name: 'api_categories_delete', methods: ['DELETE'])]
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository,$cat_id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId() , $request->request->get('_token'))) {
            $categoriesRepository->remove($category, true);

            if ($request->attributes->get('_route') === 'api_categories_delete') {
                return $this->json(null, Response::HTTP_NO_CONTENT);
            }
        }
        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
