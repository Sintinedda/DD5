<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseLevel;
use App\Form\Classes\ClasseLevelType;
use App\Repository\Classes\ClasseLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/level')]
final class ClasseLevelController extends AbstractController
{
    #[Route(name: 'app_classes_classe_level_index', methods: ['GET'])]
    public function index(ClasseLevelRepository $classeLevelRepository): Response
    {
        return $this->render('classes/classe_level/index.html.twig', [
            'classe_levels' => $classeLevelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeLevel = new ClasseLevel();
        $form = $this->createForm(ClasseLevelType::class, $classeLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeLevel);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_level/new.html.twig', [
            'classe_level' => $classeLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_level_show', methods: ['GET'])]
    public function show(ClasseLevel $classeLevel): Response
    {
        return $this->render('classes/classe_level/show.html.twig', [
            'classe_level' => $classeLevel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseLevel $classeLevel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseLevelType::class, $classeLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_level/edit.html.twig', [
            'classe_level' => $classeLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_level_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseLevel $classeLevel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeLevel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
