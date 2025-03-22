<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemSubcategory;
use App\Form\Items\ItemSubcategoryType;
use App\Repository\Items\ItemSubcategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/items/item/subcategory')]
final class ItemSubcategoryController extends AbstractController
{
    #[Route(name: 'app_items_item_subcategory_index', methods: ['GET'])]
    public function index(ItemSubcategoryRepository $itemSubcategoryRepository): Response
    {
        return $this->render('items/item_subcategory/index.html.twig', [
            'item_subcategories' => $itemSubcategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_item_subcategory_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemSubcategory = new ItemSubcategory();
        $form = $this->createForm(ItemSubcategoryType::class, $itemSubcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemSubcategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_subcategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_subcategory/new.html.twig', [
            'item_subcategory' => $itemSubcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_subcategory_show', methods: ['GET'])]
    public function show(ItemSubcategory $itemSubcategory): Response
    {
        return $this->render('items/item_subcategory/show.html.twig', [
            'item_subcategory' => $itemSubcategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_item_subcategory_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemSubcategory $itemSubcategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemSubcategoryType::class, $itemSubcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_subcategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_subcategory/edit.html.twig', [
            'item_subcategory' => $itemSubcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_subcategory_delete', methods: ['POST'])]
    public function delete(Request $request, ItemSubcategory $itemSubcategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemSubcategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemSubcategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_item_subcategory_index', [], Response::HTTP_SEE_OTHER);
    }
}
