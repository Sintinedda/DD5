<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Condition;
use App\Form\Assets\ConditionType;
use App\Repository\Assets\ConditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assets/condition')]
final class ConditionController extends AbstractController
{
    #[Route(name: 'app_assets_condition_index', methods: ['GET'])]
    public function index(ConditionRepository $conditionRepository): Response
    {
        return $this->render('assets/condition/index.html.twig', [
            'conditions' => $conditionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assets_condition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $condition = new Condition();
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($condition);
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_condition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/condition/new.html.twig', [
            'condition' => $condition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_condition_show', methods: ['GET'])]
    public function show(Condition $condition): Response
    {
        return $this->render('assets/condition/show.html.twig', [
            'condition' => $condition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assets_condition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Condition $condition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_condition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_condition_delete', methods: ['POST'])]
    public function delete(Request $request, Condition $condition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condition->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($condition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assets_condition_index', [], Response::HTTP_SEE_OTHER);
    }
}
