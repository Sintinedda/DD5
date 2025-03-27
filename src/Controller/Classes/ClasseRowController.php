<?php

namespace App\Controller\Classes;

use App\Entity\Construct\Table;
use App\Entity\Construct\TableRow;
use App\Form\Construct\TableRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-row')]
final class ClasseRowController extends AbstractController
{
    #[Route('/classe{id}/skill{id2}/new', name: 'classe_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_row/new.html.twig', [
            'classe_row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $row = $entityManager->getRepository(TableRow::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_row/edit.html.twig', [
            'classe_row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_row_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $row = $entityManager->getRepository(TableRow::class)->findOneBy(['id' => $id2]);
        
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
