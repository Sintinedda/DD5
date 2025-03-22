<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGTable;
use App\Form\Backgrounds\BGTableType;
use App\Repository\Backgrounds\BGTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backgrounds/b/g/table')]
final class BGTableController extends AbstractController
{
    #[Route(name: 'app_backgrounds_b_g_table_index', methods: ['GET'])]
    public function index(BGTableRepository $bGTableRepository): Response
    {
        return $this->render('backgrounds/bg_table/index.html.twig', [
            'b_g_tables' => $bGTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backgrounds_b_g_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bGTable = new BGTable();
        $form = $this->createForm(BGTableType::class, $bGTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bGTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/new.html.twig', [
            'b_g_table' => $bGTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_table_show', methods: ['GET'])]
    public function show(BGTable $bGTable): Response
    {
        return $this->render('backgrounds/bg_table/show.html.twig', [
            'b_g_table' => $bGTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backgrounds_b_g_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGTable $bGTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGTableType::class, $bGTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/edit.html.twig', [
            'b_g_table' => $bGTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_table_delete', methods: ['POST'])]
    public function delete(Request $request, BGTable $bGTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backgrounds_b_g_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
