<?php

namespace App\Controller\Items;

use App\Entity\Construct\Table;
use App\Entity\Construct\TableRow;
use App\Form\Construct\TableRowType;
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
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/new/cat.html.twig', [
            'item_row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}/table={id2}', name: 'item_row_sub_new', methods: ['GET', 'POST'])]
    public function newSubcategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $row = new TableRow();
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $row->setTableau($table);
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/new/sub.html.twig', [
            'item_row' => $row,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat={id2}', name: 'item_row_cat_edit', methods: ['GET', 'POST'])]
    public function editCategory(Request $request, TableRow $row, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/edit/cat.html.twig', [
            'item_row' => $row,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/sub={id2}', name: 'item_row_sub_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, TableRow $row, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(TableRowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_row/edit/sub.html.twig', [
            'item_row' => $row,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/cat={id2}', name: 'item_row_cat_delete', methods: ['POST'])]
    public function deleteCategory(Request $request, TableRow $row, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}', name: 'item_row_sub_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, TableRow $row, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }
}
