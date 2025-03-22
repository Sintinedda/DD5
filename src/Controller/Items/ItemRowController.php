<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemRow;
use App\Form\Items\ItemRowType;
use App\Repository\Items\ItemRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/items/item/row')]
final class ItemRowController extends AbstractController
{
    #[Route(name: 'app_items_item_row_index', methods: ['GET'])]
    public function index(ItemRowRepository $itemRowRepository): Response
    {
        return $this->render('items/item_row/index.html.twig', [
            'item_rows' => $itemRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_item_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemRow = new ItemRow();
        $form = $this->createForm(ItemRowType::class, $itemRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/new.html.twig', [
            'item_row' => $itemRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_row_show', methods: ['GET'])]
    public function show(ItemRow $itemRow): Response
    {
        return $this->render('items/item_row/show.html.twig', [
            'item_row' => $itemRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_item_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemRow $itemRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemRowType::class, $itemRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/edit.html.twig', [
            'item_row' => $itemRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_row_delete', methods: ['POST'])]
    public function delete(Request $request, ItemRow $itemRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_item_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
