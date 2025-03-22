<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseSubskill;
use App\Form\Classes\ClasseSubskillType;
use App\Repository\Classes\ClasseSubskillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/subskill')]
final class ClasseSubskillController extends AbstractController
{
    #[Route(name: 'app_classes_classe_subskill_index', methods: ['GET'])]
    public function index(ClasseSubskillRepository $classeSubskillRepository): Response
    {
        return $this->render('classes/classe_subskill/index.html.twig', [
            'classe_subskills' => $classeSubskillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_subskill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeSubskill = new ClasseSubskill();
        $form = $this->createForm(ClasseSubskillType::class, $classeSubskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeSubskill);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_subskill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/new.html.twig', [
            'classe_subskill' => $classeSubskill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_subskill_show', methods: ['GET'])]
    public function show(ClasseSubskill $classeSubskill): Response
    {
        return $this->render('classes/classe_subskill/show.html.twig', [
            'classe_subskill' => $classeSubskill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_subskill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseSubskill $classeSubskill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseSubskillType::class, $classeSubskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_subskill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/edit.html.twig', [
            'classe_subskill' => $classeSubskill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_subskill_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseSubskill $classeSubskill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeSubskill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeSubskill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_subskill_index', [], Response::HTTP_SEE_OTHER);
    }
}
