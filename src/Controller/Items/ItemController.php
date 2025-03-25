<?php

namespace App\Controller\Items;

use App\Entity\Items\Item;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSubcategory;
use App\Form\Items\ItemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/item')]
final class ItemController extends AbstractController
{
    #[Route('/new/cat={id}', name: 'item_cat_item_new', methods: ['GET', 'POST'])]
    public function newCategory(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id]);
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setCategory($category);
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item/new/cat.html.twig', [
            'item' => $item,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}', name: 'item_sub_item_new', methods: ['GET', 'POST'])]
    public function newSubcategory(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id]);
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setCategory($sub);
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item/new/sub.html.twig', [
            'item' => $item,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat', name: 'item_cat_item_edit', methods: ['GET', 'POST'])]
    public function editCategory(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        $id = $item->getCategory('id');
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item/edit/cat.html.twig', [
            'item' => $item,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/sub', name: 'item_sub_item_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        $id = $item->getSubcategory('id');
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item/edit/sub.html.twig', [
            'item' => $item,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/cat', name: 'item_cat_item_delete', methods: ['POST'])]
    public function deleteCategory(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        $id = $item->getCategory('id');

        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub', name: 'item_sub_item_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        $id = $item->getSubcategory('id');

        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
