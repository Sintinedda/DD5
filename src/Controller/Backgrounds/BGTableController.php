<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGCarac;
use App\Entity\Construct\Skill;
use App\Entity\Construct\Table;
use App\Form\Construct\TableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgtable')]
final class BGTableController extends AbstractController
{
    #[Route('/carac{id}/new', name: 'bgtable_carac_new', methods: ['GET', 'POST'])]
    public function newTableCarac(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $carac = $entityManager->getRepository(BGCarac::class)->findOneBy(['id' => $id]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->setBgCarac($carac);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/new.html.twig', [
            'b_g_table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/skill{id}/new', name: 'bgtable_skill_new', methods: ['GET', 'POST'])]
    public function newTableSkill(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->setSkill($skill);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/new.html.twig', [
            'b_g_table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgtable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Table $table, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_table/edit.html.twig', [
            'b_g_table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgtable_delete', methods: ['POST'])]
    public function delete(Request $request, Table $table, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($table);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
