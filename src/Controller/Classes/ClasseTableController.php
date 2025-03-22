<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseTable;
use App\Form\Classes\ClasseTableType;
use App\Repository\Classes\ClasseTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/table')]
final class ClasseTableController extends AbstractController
{
    #[Route(name: 'app_classes_classe_table_index', methods: ['GET'])]
    public function index(ClasseTableRepository $classeTableRepository): Response
    {
        return $this->render('classes/classe_table/index.html.twig', [
            'classe_tables' => $classeTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeTable = new ClasseTable();
        $form = $this->createForm(ClasseTableType::class, $classeTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_table/new.html.twig', [
            'classe_table' => $classeTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_table_show', methods: ['GET'])]
    public function show(ClasseTable $classeTable): Response
    {
        return $this->render('classes/classe_table/show.html.twig', [
            'classe_table' => $classeTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseTable $classeTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseTableType::class, $classeTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_table/edit.html.twig', [
            'classe_table' => $classeTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_table_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseTable $classeTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
