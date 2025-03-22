<?php

namespace App\Controller\Spells;

use App\Entity\Spells\SpellRow;
use App\Form\Spells\SpellRowType;
use App\Repository\Spells\SpellRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spells/spell/row')]
final class SpellRowController extends AbstractController
{
    #[Route(name: 'app_spells_spell_row_index', methods: ['GET'])]
    public function index(SpellRowRepository $spellRowRepository): Response
    {
        return $this->render('spells/spell_row/index.html.twig', [
            'spell_rows' => $spellRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spells_spell_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spellRow = new SpellRow();
        $form = $this->createForm(SpellRowType::class, $spellRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spellRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_row/new.html.twig', [
            'spell_row' => $spellRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_row_show', methods: ['GET'])]
    public function show(SpellRow $spellRow): Response
    {
        return $this->render('spells/spell_row/show.html.twig', [
            'spell_row' => $spellRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spells_spell_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpellRow $spellRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpellRowType::class, $spellRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_row/edit.html.twig', [
            'spell_row' => $spellRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_row_delete', methods: ['POST'])]
    public function delete(Request $request, SpellRow $spellRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spellRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spellRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spells_spell_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
