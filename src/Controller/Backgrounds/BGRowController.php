<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGRow;
use App\Entity\Backgrounds\BGTable;
use App\Form\Backgrounds\BGRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgrow')]
final class BGRowController extends AbstractController
{
    #[Route('/new/{id}', name: 'bgrow_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $table = $entityManager->getRepository(BGTable::class)->findOneBy(['id' => $id]); 
        $bGRow = new BGRow();
        $form = $this->createForm(BGRowType::class, $bGRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGRow->setTableau($table);
            $entityManager->persist($bGRow);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_row/new.html.twig', [
            'b_g_row' => $bGRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgrow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGRow $bGRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGRowType::class, $bGRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_row/edit.html.twig', [
            'b_g_row' => $bGRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgrow_delete', methods: ['POST'])]
    public function delete(Request $request, BGRow $bGRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
