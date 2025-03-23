<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Condition;
use App\Form\Assets\ConditionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/condition')]
final class ConditionController extends AbstractController
{
    #[Route('/new', name: 'condition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $condition = new Condition();
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($condition);
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/condition/new.html.twig', [
            'condition' => $condition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'condition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Condition $condition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'condition_delete', methods: ['POST'])]
    public function delete(Request $request, Condition $condition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condition->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($condition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
    }
}
