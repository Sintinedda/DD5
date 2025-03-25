<?php

namespace App\Controller\Items;

use App\Entity\Items\Item;
use App\Entity\Items\ItemSkill;
use App\Entity\Items\ItemSubcategory;
use App\Entity\Items\ItemTable;
use App\Form\Items\ItemTableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/item-table')]
final class ItemTableController extends AbstractController
{
    #[Route('/new/cat={id}/skill={id2}', name: 'item_table_skill_cat_new', methods: ['GET', 'POST'])]
    public function newSkillCategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(ItemSkill::class)->findOneBy(['id' => $id2]);
        $itemTable = new ItemTable();
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->setSkill($skill);
            $entityManager->persist($itemTable);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/new/cat.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}/skill={id2}', name: 'item_table_skill_sub_new', methods: ['GET', 'POST'])]
    public function newSkillSubcategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(ItemSkill::class)->findOneBy(['id' => $id2]);
        $itemTable = new ItemTable();
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->setSkill($skill);
            $entityManager->persist($itemTable);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/new/sub.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}', name: 'item_table_sub_new', methods: ['GET', 'POST'])]
    public function newSubcategory(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id]);
        $itemTable = new ItemTable();
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->addSubcategory($sub);
            $entityManager->persist($itemTable);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/new/sub.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/cat={id}/item={id2}', name: 'item_table_item_cat_new', methods: ['GET', 'POST'])]
    public function newItemCategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id' => $id2]);
        $itemTable = new ItemTable();
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->addItem($item);
            $entityManager->persist($itemTable);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/new/cat.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}/item={id2}', name: 'item_table_item_sub_new', methods: ['GET', 'POST'])]
    public function newItemSubcategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id' => $id2]);
        $itemTable = new ItemTable();
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->addItem($item);
            $entityManager->persist($itemTable);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/new/sub.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat={id2}/skill', name: 'item_table_skill_cat_edit', methods: ['GET', 'POST'])]
    public function editSkillCategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/edit/cat.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/sub={id2}/skill', name: 'item_table_skill_sub_edit', methods: ['GET', 'POST'])]
    public function editSkillSubcategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/edit/sub.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/sub={id2}', name: 'item_table_sub_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->addSubcategory($sub);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/edit/sub.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/cat={id2}/item={id3}', name: 'item_table_item_cat_edit', methods: ['GET', 'POST'])]
    public function editItemCategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2, int $id3): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id' => $id3]);
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->addItem($item);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/edit/cat.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/sub={id2}/item={id3}', name: 'item_table_item_sub_edit', methods: ['GET', 'POST'])]
    public function editItemSubategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2, int $id3): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id' => $id3]);
        $form = $this->createForm(ItemTableType::class, $itemTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemTable->addItem($item);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_table/edit/sub.html.twig', [
            'item_table' => $itemTable,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/cat={id2}', name: 'item_table_skill_cat_delete', methods: ['POST'])]
    public function deleteSkillCategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub-skill={id2}', name: 'item_table_skill_sub_delete', methods: ['POST'])]
    public function deleteSkillSubcategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}', name: 'item_table_sub_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);
        if ($this->isCsrfTokenValid('delete'.$itemTable->getId(), $request->getPayload()->getString('_token'))) {
            $itemTable->removeSubcategory($sub);
            if ($itemTable->getSubcategories()->count() == 0) {
                $entityManager->remove($itemTable);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/cat={id2}/item{id3}', name: 'item_table_item_cat_delete', methods: ['POST'])]
    public function deleteItemCategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2, int $id3): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id' => $id3]);
        if ($this->isCsrfTokenValid('delete'.$itemTable->getId(), $request->getPayload()->getString('_token'))) {
            $itemTable->removeItem($item);
            if ($itemTable->getItems()->count() == 0) {
                $entityManager->remove($itemTable);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}/item{id3}', name: 'item_table_item_sub_delete', methods: ['POST'])]
    public function deleteItemSubcategory(Request $request, ItemTable $itemTable, EntityManagerInterface $entityManager, int $id2, int $id3): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id' => $id3]);
        if ($this->isCsrfTokenValid('delete'.$itemTable->getId(), $request->getPayload()->getString('_token'))) {
            $itemTable->removeItem($item);
            if ($itemTable->getItems()->count() == 0) {
                $entityManager->remove($itemTable);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }
}
