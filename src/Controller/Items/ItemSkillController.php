<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSkill;
use App\Entity\Items\ItemSubcategory;
use App\Form\Items\ItemSkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/item-skill')]
final class ItemSkillController extends AbstractController
{
    #[Route('/new/cat={id}', name: 'item_skill_cat_new', methods: ['GET', 'POST'])]
    public function newCategory(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $cat = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id]);
        $itemSkill = new ItemSkill();
        $form = $this->createForm(ItemSkillType::class, $itemSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemSkill->addItemCategory($cat);
            $entityManager->persist($itemSkill);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/new/cat.html.twig', [
            'item_skill' => $itemSkill,
            'form' => $form,
        ]);
    }

    #[Route('/new/sub={id}', name: 'item_skill_sub_new', methods: ['GET', 'POST'])]
    public function newSubcategory(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id]);
        $itemSkill = new ItemSkill();
        $form = $this->createForm(ItemSkillType::class, $itemSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemSkill->addSubcategory($sub);
            $entityManager->persist($itemSkill);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/new/sub.html.twig', [
            'item_skill' => $itemSkill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat={id2}', name: 'item_skill_cat_edit', methods: ['GET', 'POST'])]
    public function editCategory(Request $request, ItemSkill $itemSkill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $cat = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ItemSkillType::class, $itemSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemSkill->addItemCategory($cat);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/edit/cat.html.twig', [
            'item_skill' => $itemSkill,
            'form' => $form,
            'id' => $id2
        ]);
    
    }

    #[Route('/{id}/edit/sub={id2}', name: 'item_skill_sub_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, ItemSkill $itemSkill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ItemSkillType::class, $itemSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemSkill->addSubcategory($sub);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/edit/sub.html.twig', [
            'item_skill' => $itemSkill,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/cat={id2}', name: 'item_skill_cat_delete', methods: ['POST'])]
    public function deleteCategory(Request $request, ItemSkill $itemSkill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $cat = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$itemSkill->getId(), $request->getPayload()->getString('_token'))) {
            $itemSkill->removeItemCategory($cat);
            if ($itemSkill->getItemCategories()->count() == 0) {
                $entityManager->remove($itemSkill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}', name: 'item_skill_sub_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, ItemSkill $itemSkill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$itemSkill->getId(), $request->getPayload()->getString('_token'))) {
            $itemSkill->removeSubcategory($sub);
            if ($itemSkill->getSubcategories()->count() == 0) {
                $entityManager->remove($itemSkill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }
}
