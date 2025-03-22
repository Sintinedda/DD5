<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyTable;
use App\Form\Classes\SpecialtyTableType;
use App\Repository\Classes\SpecialtyTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/specialty/table')]
final class SpecialtyTableController extends AbstractController
{
    #[Route(name: 'app_classes_specialty_table_index', methods: ['GET'])]
    public function index(SpecialtyTableRepository $specialtyTableRepository): Response
    {
        return $this->render('classes/specialty_table/index.html.twig', [
            'specialty_tables' => $specialtyTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_specialty_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialtyTable = new SpecialtyTable();
        $form = $this->createForm(SpecialtyTableType::class, $specialtyTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialtyTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_table/new.html.twig', [
            'specialty_table' => $specialtyTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_table_show', methods: ['GET'])]
    public function show(SpecialtyTable $specialtyTable): Response
    {
        return $this->render('classes/specialty_table/show.html.twig', [
            'specialty_table' => $specialtyTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_specialty_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpecialtyTable $specialtyTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialtyTableType::class, $specialtyTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_table/edit.html.twig', [
            'specialty_table' => $specialtyTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_table_delete', methods: ['POST'])]
    public function delete(Request $request, SpecialtyTable $specialtyTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialtyTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialtyTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_specialty_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
