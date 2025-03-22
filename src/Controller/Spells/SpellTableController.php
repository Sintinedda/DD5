<?php

namespace App\Controller\Spells;

use App\Entity\Spells\SpellTable;
use App\Form\Spells\SpellTableType;
use App\Repository\Spells\SpellTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spells/spell/table')]
final class SpellTableController extends AbstractController
{
    #[Route(name: 'app_spells_spell_table_index', methods: ['GET'])]
    public function index(SpellTableRepository $spellTableRepository): Response
    {
        return $this->render('spells/spell_table/index.html.twig', [
            'spell_tables' => $spellTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spells_spell_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spellTable = new SpellTable();
        $form = $this->createForm(SpellTableType::class, $spellTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spellTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_table/new.html.twig', [
            'spell_table' => $spellTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_table_show', methods: ['GET'])]
    public function show(SpellTable $spellTable): Response
    {
        return $this->render('spells/spell_table/show.html.twig', [
            'spell_table' => $spellTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spells_spell_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpellTable $spellTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpellTableType::class, $spellTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_table/edit.html.twig', [
            'spell_table' => $spellTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_table_delete', methods: ['POST'])]
    public function delete(Request $request, SpellTable $spellTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spellTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spellTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spells_spell_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
