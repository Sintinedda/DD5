<?php

namespace App\Controller\Backgrounds;

use App\Entity\Construct\Table;
use App\Entity\Construct\TableRow;
use App\Form\Construct\TableRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgrow')]
final class BGRowController extends AbstractController
{
    #[Route('/bg{id}/new', name: 'bgrow_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id]); 
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_row/new.html.twig', [
            'b_g_row' => $row,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgrow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TableRow $row, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_row/edit.html.twig', [
            'b_g_row' => $row,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgrow_delete', methods: ['POST'])]
    public function delete(Request $request, TableRow $row, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
