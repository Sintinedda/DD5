<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemRow;
use App\Entity\Items\ItemTable;
use App\Form\Items\ItemRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/item-row')]
final class ItemRowController extends AbstractController
{
    #[Route('/new/cat={id}/table={id2}', name: 'item_row_cat_new', methods: ['GET', 'POST'])]
    public function newCategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(ItemTable::class)->findOneBy(['id' => $id2]);
        $itemRow = new ItemRow();
        $form = $this->createForm(ItemRowType::class, $itemRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRow->setTableau($table);
            $entityManager->persist($itemRow);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/new/cat.html.twig', [
            'item_row' => $itemRow,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}/table={id2}', name: 'item_row_sub_new', methods: ['GET', 'POST'])]
    public function newSubcategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(ItemTable::class)->findOneBy(['id' => $id2]);
        $itemRow = new ItemRow();
        $form = $this->createForm(ItemRowType::class, $itemRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRow->setTableau($table);
            $entityManager->persist($itemRow);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/new/sub.html.twig', [
            'item_row' => $itemRow,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat={id2}', name: 'item_row_cat_edit', methods: ['GET', 'POST'])]
    public function editCategory(Request $request, ItemRow $itemRow, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(ItemRowType::class, $itemRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/edit/cat.html.twig', [
            'item_row' => $itemRow,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/sub={id2}', name: 'item_row_sub_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, ItemRow $itemRow, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(ItemRowType::class, $itemRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/edit/sub.html.twig', [
            'item_row' => $itemRow,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/cat={id2}', name: 'item_row_cat_delete', methods: ['POST'])]
    public function deleteCategory(Request $request, ItemRow $itemRow, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}', name: 'item_row_sub_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, ItemRow $itemRow, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }
}
