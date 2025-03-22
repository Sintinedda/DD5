<?php

namespace App\Controller\Construct;

use App\Entity\Construct\TableRow;
use App\Form\Construct\TableRowType;
use App\Repository\Construct\TableRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/construct/table/row')]
final class TableRowController extends AbstractController
{
    #[Route(name: 'app_construct_table_row_index', methods: ['GET'])]
    public function index(TableRowRepository $tableRowRepository): Response
    {
        return $this->render('construct/table_row/index.html.twig', [
            'table_rows' => $tableRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_construct_table_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tableRow = new TableRow();
        $form = $this->createForm(TableRowType::class, $tableRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tableRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_construct_table_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construct/table_row/new.html.twig', [
            'table_row' => $tableRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_construct_table_row_show', methods: ['GET'])]
    public function show(TableRow $tableRow): Response
    {
        return $this->render('construct/table_row/show.html.twig', [
            'table_row' => $tableRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_construct_table_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TableRow $tableRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableRowType::class, $tableRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_construct_table_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construct/table_row/edit.html.twig', [
            'table_row' => $tableRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_construct_table_row_delete', methods: ['POST'])]
    public function delete(Request $request, TableRow $tableRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tableRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tableRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_construct_table_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
