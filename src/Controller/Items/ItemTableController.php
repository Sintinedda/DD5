<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemTable;
use App\Form\Items\ItemTableType;
use App\Repository\Items\ItemTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/items/item/table')]
final class ItemTableController extends AbstractController
{
    #[Route(name: 'app_items_item_table_index', methods: ['GET'])]
    public function index(ItemTableRepository $itemTableRepository): Response
    {
        return $this->render('items/item_table/index.html.twig', [
            'item_tables' => $itemTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_item_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemTable = new ItemTable();
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/new.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_table_show', methods: ['GET'])]
    public function show(ItemTable $itemTable): Response
    {
        return $this->render('items/item_table/show.html.twig', [
            'item_table' => $itemTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_item_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/edit.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_table_delete', methods: ['POST'])]
    public function delete(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_item_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
