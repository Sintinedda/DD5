<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyRow;
use App\Entity\Classes\SpecialtyTable;
use App\Form\Classes\SpecialtyRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialty-row')]
final class SpecialtyRowController extends AbstractController
{
    #[Route('/spe{id}/item{id2}/table{id3}/new', name: 'specialty_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $table = $entityManager->getRepository(SpecialtyTable::class)->findOneBy(['id' => $id3]);
        $specialtyRow = new SpecialtyRow();
        $form = $this->createForm(SpecialtyRowType::class, $specialtyRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtyRow->setTableau($table);
            $entityManager->persist($specialtyRow);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_row/new.html.twig', [
            'specialty_row' => $specialtyRow,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}/edit', name: 'specialty_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $specialtyRow = $entityManager->getRepository(SpecialtyRow::class)->findOneBy(['id' => $id3]);
        $form = $this->createForm(SpecialtyRowType::class, $specialtyRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_row/edit.html.twig', [
            'specialty_row' => $specialtyRow,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}', name: 'specialty_row_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $specialtyRow = $entityManager->getRepository(SpecialtyRow::class)->findOneBy(['id' => $id3]);
        
        if ($this->isCsrfTokenValid('delete'.$specialtyRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialtyRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
    }
}
