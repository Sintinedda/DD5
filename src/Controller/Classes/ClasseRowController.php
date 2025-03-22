<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseRow;
use App\Form\Classes\ClasseRowType;
use App\Repository\Classes\ClasseRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/row')]
final class ClasseRowController extends AbstractController
{
    #[Route(name: 'app_classes_classe_row_index', methods: ['GET'])]
    public function index(ClasseRowRepository $classeRowRepository): Response
    {
        return $this->render('classes/classe_row/index.html.twig', [
            'classe_rows' => $classeRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeRow = new ClasseRow();
        $form = $this->createForm(ClasseRowType::class, $classeRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_row/new.html.twig', [
            'classe_row' => $classeRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_row_show', methods: ['GET'])]
    public function show(ClasseRow $classeRow): Response
    {
        return $this->render('classes/classe_row/show.html.twig', [
            'classe_row' => $classeRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseRow $classeRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseRowType::class, $classeRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_row/edit.html.twig', [
            'classe_row' => $classeRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_row_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseRow $classeRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
