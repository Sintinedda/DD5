<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyItem;
use App\Entity\Classes\SpecialtySkill;
use App\Entity\Classes\SpecialtyTable;
use App\Form\Classes\SpecialtyTableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialty-table')]
final class SpecialtyTableController extends AbstractController
{
    #[Route('/spe{id}/item{id2}/new', name: 'specialty_table_new', methods: ['GET', 'POST'])]
    public function newSpecialty(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $spe = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $specialtyTable = new SpecialtyTable();
        $form = $this->createForm(SpecialtyTableType::class, $specialtyTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtyTable->addSpecialty($spe);
            $entityManager->persist($specialtyTable);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_table/new.html.twig', [
            'specialty_table' => $specialtyTable,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/skill{id3}/new', name: 'specialty_table_skill_new', methods: ['GET', 'POST'])]
    public function newSkill(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $skill = $entityManager->getRepository(SpecialtySkill::class)->findOneBy(['id' => $id3]);
        $specialtyTable = new SpecialtyTable();
        $form = $this->createForm(SpecialtyTableType::class, $specialtyTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtyTable->setSkill($skill);
            $entityManager->persist($specialtyTable);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_table/new.html.twig', [
            'specialty_table' => $specialtyTable,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}/edit', name: 'specialty_table_edit', methods: ['GET', 'POST'])]
    public function editSpecialty(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $spe = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $specialtyTable = $entityManager->getRepository(SpecialtyTable::class)->findOneBy(['id' => $id3]);
        $form = $this->createForm(SpecialtyTableType::class, $specialtyTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($specialtyTable->getSpecialties()->count() != 0) {
                $specialtyTable->addSpecialty($spe);
            } 
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_table/edit.html.twig', [
            'specialty_table' => $specialtyTable,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}', name: 'specialty_table_delete', methods: ['POST'])]
    public function delete(Request $request, SpecialtyTable $specialtyTable, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $spe = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $specialtyTable = $entityManager->getRepository(SpecialtyTable::class)->findOneBy(['id' => $id3]);

        if ($this->isCsrfTokenValid('delete'.$specialtyTable->getId(), $request->getPayload()->getString('_token'))) {
            if ($specialtyTable->getSpecialties()->count() != 0) {
                $specialtyTable->removeSpecialty($spe);
                if ($specialtyTable->getSpecialties()->count() == 0) {
                    $entityManager->remove($specialtyTable);
                }
            } else {
                $entityManager->remove($specialtyTable);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
    }
}
