<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyRow;
use App\Form\Classes\SpecialtyRowType;
use App\Repository\Classes\SpecialtyRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/specialty/row')]
final class SpecialtyRowController extends AbstractController
{
    #[Route(name: 'app_classes_specialty_row_index', methods: ['GET'])]
    public function index(SpecialtyRowRepository $specialtyRowRepository): Response
    {
        return $this->render('classes/specialty_row/index.html.twig', [
            'specialty_rows' => $specialtyRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_specialty_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialtyRow = new SpecialtyRow();
        $form = $this->createForm(SpecialtyRowType::class, $specialtyRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialtyRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_row/new.html.twig', [
            'specialty_row' => $specialtyRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_row_show', methods: ['GET'])]
    public function show(SpecialtyRow $specialtyRow): Response
    {
        return $this->render('classes/specialty_row/show.html.twig', [
            'specialty_row' => $specialtyRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_specialty_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpecialtyRow $specialtyRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialtyRowType::class, $specialtyRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_row/edit.html.twig', [
            'specialty_row' => $specialtyRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_row_delete', methods: ['POST'])]
    public function delete(Request $request, SpecialtyRow $specialtyRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialtyRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialtyRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_specialty_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
