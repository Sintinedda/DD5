<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseSpellcasting;
use App\Form\Classes\ClasseSpellcastingType;
use App\Repository\Classes\ClasseSpellcastingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/spellcasting')]
final class ClasseSpellcastingController extends AbstractController
{
    #[Route(name: 'app_classes_classe_spellcasting_index', methods: ['GET'])]
    public function index(ClasseSpellcastingRepository $classeSpellcastingRepository): Response
    {
        return $this->render('classes/classe_spellcasting/index.html.twig', [
            'classe_spellcastings' => $classeSpellcastingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_spellcasting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeSpellcasting = new ClasseSpellcasting();
        $form = $this->createForm(ClasseSpellcastingType::class, $classeSpellcasting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeSpellcasting);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_spellcasting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_spellcasting/new.html.twig', [
            'classe_spellcasting' => $classeSpellcasting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_spellcasting_show', methods: ['GET'])]
    public function show(ClasseSpellcasting $classeSpellcasting): Response
    {
        return $this->render('classes/classe_spellcasting/show.html.twig', [
            'classe_spellcasting' => $classeSpellcasting,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_spellcasting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseSpellcasting $classeSpellcasting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseSpellcastingType::class, $classeSpellcasting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_spellcasting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_spellcasting/edit.html.twig', [
            'classe_spellcasting' => $classeSpellcasting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_spellcasting_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseSpellcasting $classeSpellcasting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeSpellcasting->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeSpellcasting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_spellcasting_index', [], Response::HTTP_SEE_OTHER);
    }
}
