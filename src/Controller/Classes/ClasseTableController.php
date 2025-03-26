<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseSkill;
use App\Entity\Classes\ClasseTable;
use App\Form\Classes\ClasseTableType;
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
        $skill = $entityManager->getRepository(ClasseSkill::class)->findOneBy(['id' => $id2]);
        $classeTable = new ClasseTable();
        $form = $this->createForm(ClasseTableType::class, $classeTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeTable->setSkill($skill);
            $entityManager->persist($classeTable);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_table/new.html.twig', [
            'classe_table' => $classeTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeTable = $entityManager->getRepository(ClasseTable::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ClasseTableType::class, $classeTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_table/edit.html.twig', [
            'classe_table' => $classeTable,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_table_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeTable = $entityManager->getRepository(ClasseTable::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$classeTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
