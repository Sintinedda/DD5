<?php

namespace App\Controller\Construct;

use App\Entity\Construct\Liste;
use App\Form\Construct\ListeType;
use App\Repository\Construct\ListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/construct/liste')]
final class ListeController extends AbstractController
{
    #[Route(name: 'app_construct_liste_index', methods: ['GET'])]
    public function index(ListeRepository $listeRepository): Response
    {
        return $this->render('construct/liste/index.html.twig', [
            'listes' => $listeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_construct_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('app_construct_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construct/liste/new.html.twig', [
            'liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_construct_liste_show', methods: ['GET'])]
    public function show(Liste $liste): Response
    {
        return $this->render('construct/liste/show.html.twig', [
            'liste' => $liste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_construct_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_construct_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construct/liste/edit.html.twig', [
            'liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_construct_liste_delete', methods: ['POST'])]
    public function delete(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_construct_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
