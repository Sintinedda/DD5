<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGCarac;
use App\Entity\Backgrounds\BGSkill;
use App\Entity\Backgrounds\BGTable;
use App\Form\Backgrounds\BGTableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgtable')]
final class BGTableController extends AbstractController
{
    #[Route('/new/carac={id}', name: 'bgtable_carac_new', methods: ['GET', 'POST'])]
    public function newTableCarac(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $carac = $entityManager->getRepository(BGCarac::class)->findOneBy(['id' => $id]);
        $bGTable = new BGTable();
        $form = $this->createForm(BGTableType::class, $bGTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGTable->setBGCarac($carac);
            $entityManager->persist($bGTable);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/new.html.twig', [
            'b_g_table' => $bGTable,
            'form' => $form,
        ]);
    }

    #[Route('/new/skill={id}', name: 'bgtable_skill_new', methods: ['GET', 'POST'])]
    public function newTableSkill(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = $entityManager->getRepository(BGSkill::class)->findOneBy(['id' => $id]);
        $bGTable = new BGTable();
        $form = $this->createForm(BGTableType::class, $bGTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGTable->setSkill($skill);
            $entityManager->persist($bGTable);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/new.html.twig', [
            'b_g_table' => $bGTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgtable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGTable $bGTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGTableType::class, $bGTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/edit.html.twig', [
            'b_g_table' => $bGTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgtable_delete', methods: ['POST'])]
    public function delete(Request $request, BGTable $bGTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
