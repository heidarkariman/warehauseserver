<?php

namespace App\Controller;

use App\Entity\UserRoles;
use App\Form\UserRolesType;
use App\Repository\UserRolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/roles')]
class UserRolesController extends AbstractController
{
    #[Route('/', name: 'app_user_roles_index', methods: ['GET'])]
    public function index(UserRolesRepository $userRolesRepository): Response
    {
        return $this->render('user_roles/index.html.twig', [
            'user_roles' => $userRolesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_roles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRolesRepository $userRolesRepository): Response
    {
        $userRole = new UserRoles();
        $form = $this->createForm(UserRolesType::class, $userRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRolesRepository->save($userRole, true);

            return $this->redirectToRoute('app_user_roles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_roles/new.html.twig', [
            'user_role' => $userRole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_roles_show', methods: ['GET'])]
    public function show(UserRoles $userRole): Response
    {
        return $this->render('user_roles/show.html.twig', [
            'user_role' => $userRole,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_roles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRoles $userRole, UserRolesRepository $userRolesRepository): Response
    {
        $form = $this->createForm(UserRolesType::class, $userRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRolesRepository->save($userRole, true);

            return $this->redirectToRoute('app_user_roles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_roles/edit.html.twig', [
            'user_role' => $userRole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_roles_delete', methods: ['POST'])]
    public function delete(Request $request, UserRoles $userRole, UserRolesRepository $userRolesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userRole->getId(), $request->request->get('_token'))) {
            $userRolesRepository->remove($userRole, true);
        }

        return $this->redirectToRoute('app_user_roles_index', [], Response::HTTP_SEE_OTHER);
    }
}
