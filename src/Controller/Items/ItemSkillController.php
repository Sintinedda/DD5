<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemSkill;
use App\Form\Items\ItemSkillType;
use App\Repository\Items\ItemSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/items/item/skill')]
final class ItemSkillController extends AbstractController
{
    #[Route(name: 'app_items_item_skill_index', methods: ['GET'])]
    public function index(ItemSkillRepository $itemSkillRepository): Response
    {
        return $this->render('items/item_skill/index.html.twig', [
            'item_skills' => $itemSkillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_item_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemSkill = new ItemSkill();
        $form = $this->createForm(ItemSkillType::class, $itemSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemSkill);
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/new.html.twig', [
            'item_skill' => $itemSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_skill_show', methods: ['GET'])]
    public function show(ItemSkill $itemSkill): Response
    {
        return $this->render('items/item_skill/show.html.twig', [
            'item_skill' => $itemSkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_item_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemSkill $itemSkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemSkillType::class, $itemSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_skill/edit.html.twig', [
            'item_skill' => $itemSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_skill_delete', methods: ['POST'])]
    public function delete(Request $request, ItemSkill $itemSkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemSkill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_item_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
