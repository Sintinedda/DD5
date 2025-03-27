<?php

namespace App\Controller\Spells;

use App\Entity\Construct\Table;
use App\Entity\Construct\TableRow;
use App\Form\Construct\TableRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/spell-row')]
final class SpellRowController extends AbstractController
{
    #[Route('/table{id}/new', name: 'spell_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id]);
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_row/new.html.twig', [
            'spell_row' => $row,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'spell_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TableRow $row, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_row/edit.html.twig', [
            'spell_row' => $row,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'spell_row_delete', methods: ['POST'])]
    public function delete(Request $request, TableRow $row, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
    }
}
