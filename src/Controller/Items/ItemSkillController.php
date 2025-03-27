<?php

namespace App\Controller\Items;

use App\Entity\Construct\Skill;
use App\Entity\Items\ItemCategory;
use App\Entity\Items\ItemSubcategory;
use App\Form\Construct\SkillType;
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
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addItemCategory($cat);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/new/cat.html.twig', [
            'item_skill' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/new/sub={id}', name: 'item_skill_sub_new', methods: ['GET', 'POST'])]
    public function newSubcategory(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id]);
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addItemSubcategory($sub);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/new/sub.html.twig', [
            'item_skill' => $skill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat={id2}', name: 'item_skill_cat_edit', methods: ['GET', 'POST'])]
    public function editCategory(Request $request, Skill $skill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $cat = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addItemCategory($cat);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/edit/cat.html.twig', [
            'item_skill' => $skill,
            'form' => $form,
            'id' => $id2
        ]);
    
    }

    #[Route('/{id}/edit/sub={id2}', name: 'item_skill_sub_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, Skill $skill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addItemSubcategory($sub);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/edit/sub.html.twig', [
            'item_skill' => $skill,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/cat={id2}', name: 'item_skill_cat_delete', methods: ['POST'])]
    public function deleteCategory(Request $request, Skill $skill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $cat = $entityManager->getRepository(ItemCategory::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->getPayload()->getString('_token'))) {
            $skill->removeItemCategory($cat);
            if ($skill->getItemCategories()->count() == 0) {
                $entityManager->remove($skill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}', name: 'item_skill_sub_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, Skill $skill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->getPayload()->getString('_token'))) {
            $skill->removeItemSubcategory($sub);
            if ($skill->getItemSubcategories()->count() == 0) {
                $entityManager->remove($skill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }
}
