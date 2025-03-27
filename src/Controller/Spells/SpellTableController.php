<?php

namespace App\Controller\Spells;

use App\Entity\Construct\Table;
use App\Entity\Spells\Spell;
use App\Form\Construct\TableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/spell-table')]
final class SpellTableController extends AbstractController
{
    #[Route('/spell{id}/new', name: 'spell_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $spell = $entityManager->getRepository(Spell::class)->findOneBy(['id' => $id]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->setSpell($spell);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_table/new.html.twig', [
            'spell_table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'spell_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Table $table, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_table/edit.html.twig', [
            'spell_table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'spell_table_delete', methods: ['POST'])]
    public function delete(Request $request, Table $table, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($table);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
    }
}
