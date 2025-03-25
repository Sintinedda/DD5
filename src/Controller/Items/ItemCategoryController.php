<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemCategory;
use App\Form\Items\ItemCategoryType;
use App\Repository\Items\ItemCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/items')]
final class ItemCategoryController extends AbstractController
{
    #[Route(name: 'items', methods: ['GET'])]
    public function index(ItemCategoryRepository $itemCategoryRepository): Response
    {
        return $this->render('items/item_category/index.html.twig', [
            'item_categories' => $itemCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'items_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemCategory = new ItemCategory();
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemCategory);
            $entityManager->flush();

            return $this->redirectToRoute('items', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_category/new.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'items_show', methods: ['GET'])]
    public function show(ItemCategory $itemCategory): Response
    {
        return $this->render('items/item_category/show.html.twig', [
            'item_category' => $itemCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemCategory $itemCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('items', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_category/edit.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'items_delete', methods: ['POST'])]
    public function delete(Request $request, ItemCategory $itemCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items', [], Response::HTTP_SEE_OTHER);
    }
}
