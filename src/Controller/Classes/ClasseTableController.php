<?php

namespace App\Controller\Classes;

use App\Entity\Construct\Skill;
use App\Entity\Construct\Table;
use App\Form\Construct\TableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-table')]
final class ClasseTableController extends AbstractController
{
    #[Route('/classe{id}/skill{id2}/new', name: 'classe_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->setSkill($skill);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_table/new.html.twig', [
            'classe_table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_table/edit.html.twig', [
            'classe_table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_table_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($table);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
