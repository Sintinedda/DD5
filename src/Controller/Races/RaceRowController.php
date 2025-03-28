<?php

namespace App\Controller\Races;

use App\Entity\Construct\Table;
use App\Entity\Construct\TableRow;
use App\Form\Construct\TableRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/race-row')]
final class RaceRowController extends AbstractController
{
    #[Route('/srace{id}/table{id2}/new', name: 'srace_row_new', methods: ['GET', 'POST'])]
    public function newSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_row/new/srace.html.twig', [
            'row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/table{id2}/new', name: 'ssrace_row_new', methods: ['GET', 'POST'])]
    public function newSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_row/new/ssrace.html.twig', [
            'row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}/edit', name: 'srace_row_edit', methods: ['GET', 'POST'])]
    public function editSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $row = $entityManager->getRepository(TableRow::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_row/edit/srace.html.twig', [
            'row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/{id2}/edit', name: 'ssrace_row_edit', methods: ['GET', 'POST'])]
    public function editSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $row = $entityManager->getRepository(TableRow::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_row/edit/ssrace.html.twig', [
            'row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}', name: 'srace_row_delete', methods: ['POST'])]
    public function deleteSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $row = $entityManager->getRepository(TableRow::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ssrace{id}/{id2}', name: 'ssrace_row_delete', methods: ['POST'])]
    public function deleteSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $row = $entityManager->getRepository(TableRow::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
