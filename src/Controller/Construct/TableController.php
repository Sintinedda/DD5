<?php

namespace App\Controller\Construct;

use App\Entity\Construct\Table;
use App\Form\Construct\TableType;
use App\Repository\Construct\TableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/construct/table')]
final class TableController extends AbstractController
{
    #[Route(name: 'app_construct_table_index', methods: ['GET'])]
    public function index(TableRepository $tableRepository): Response
    {
        return $this->render('construct/table/index.html.twig', [
            'tables' => $tableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_construct_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('app_construct_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construct/table/new.html.twig', [
            'table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_construct_table_show', methods: ['GET'])]
    public function show(Table $table): Response
    {
        return $this->render('construct/table/show.html.twig', [
            'table' => $table,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_construct_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Table $table, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_construct_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construct/table/edit.html.twig', [
            'table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_construct_table_delete', methods: ['POST'])]
    public function delete(Request $request, Table $table, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($table);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_construct_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
