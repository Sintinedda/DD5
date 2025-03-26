<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseRow;
use App\Entity\Classes\ClasseTable;
use App\Form\Classes\ClasseRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-row')]
final class ClasseRowController extends AbstractController
{
    #[Route('/classe{id}/skill{id2}/new', name: 'classe_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $table = $entityManager->getRepository(ClasseTable::class)->findOneBy(['id' => $id2]);
        $classeRow = new ClasseRow();
        $form = $this->createForm(ClasseRowType::class, $classeRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeRow->setTableau($table);
            $entityManager->persist($classeRow);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_row/new.html.twig', [
            'classe_row' => $classeRow,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeRow = $entityManager->getRepository(ClasseRow::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ClasseRowType::class, $classeRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_row/edit.html.twig', [
            'classe_row' => $classeRow,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_row_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeRow = $entityManager->getRepository(ClasseRow::class)->findOneBy(['id' => $id2]);
        
        if ($this->isCsrfTokenValid('delete'.$classeRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
