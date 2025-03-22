<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGRow;
use App\Form\Backgrounds\BGRowType;
use App\Repository\Backgrounds\BGRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backgrounds/b/g/row')]
final class BGRowController extends AbstractController
{
    #[Route(name: 'app_backgrounds_b_g_row_index', methods: ['GET'])]
    public function index(BGRowRepository $bGRowRepository): Response
    {
        return $this->render('backgrounds/bg_row/index.html.twig', [
            'b_g_rows' => $bGRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backgrounds_b_g_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bGRow = new BGRow();
        $form = $this->createForm(BGRowType::class, $bGRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bGRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_row/new.html.twig', [
            'b_g_row' => $bGRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_row_show', methods: ['GET'])]
    public function show(BGRow $bGRow): Response
    {
        return $this->render('backgrounds/bg_row/show.html.twig', [
            'b_g_row' => $bGRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backgrounds_b_g_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGRow $bGRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGRowType::class, $bGRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_row/edit.html.twig', [
            'b_g_row' => $bGRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_row_delete', methods: ['POST'])]
    public function delete(Request $request, BGRow $bGRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backgrounds_b_g_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
