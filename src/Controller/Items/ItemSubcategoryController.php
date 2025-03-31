<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSubcategory;
use App\Form\Items\ItemSubcategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/item-sub')]
final class ItemSubcategoryController extends AbstractController
{
    #[Route('/new/{id}', name: 'item_sub_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id]);
        $itemSubcategory = new ItemSubcategory();
        $form = $this->createForm(ItemSubcategoryType::class, $itemSubcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemSubcategory->setCategory($category);
            $entityManager->persist($itemSubcategory);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_subcategory/new.html.twig', [
            'item_subcategory' => $itemSubcategory,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'item_sub_show', methods: ['GET'])]
    public function show(ItemSubcategory $itemSubcategory): Response
    {
        return $this->render('items/item_subcategory/show.html.twig', [
            'item_subcategory' => $itemSubcategory,
            'id' => $itemSubcategory->getCategory()->getId()
        ]);
    }

    #[Route('/{id}/edit', name: 'item_sub_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemSubcategory $itemSubcategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemSubcategoryType::class, $itemSubcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $itemSubcategory->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_subcategory/edit.html.twig', [
            'item_subcategory' => $itemSubcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'item_sub_delete', methods: ['POST'])]
    public function delete(Request $request, ItemSubcategory $itemSubcategory, EntityManagerInterface $entityManager): Response
    {
        $id = $itemSubcategory->getCategory()->getId();

        if ($this->isCsrfTokenValid('delete'.$itemSubcategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemSubcategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
