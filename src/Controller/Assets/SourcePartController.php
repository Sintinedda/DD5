<?php

namespace App\Controller\Assets;

use App\Entity\Assets\SourcePart;
use App\Form\Assets\SourcePartType;
use App\Repository\Assets\SourcePartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assets/source/part')]
final class SourcePartController extends AbstractController
{
    #[Route(name: 'app_assets_source_part_index', methods: ['GET'])]
    public function index(SourcePartRepository $sourcePartRepository): Response
    {
        return $this->render('assets/source_part/index.html.twig', [
            'source_parts' => $sourcePartRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assets_source_part_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sourcePart = new SourcePart();
        $form = $this->createForm(SourcePartType::class, $sourcePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sourcePart);
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_source_part_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/source_part/new.html.twig', [
            'source_part' => $sourcePart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_source_part_show', methods: ['GET'])]
    public function show(SourcePart $sourcePart): Response
    {
        return $this->render('assets/source_part/show.html.twig', [
            'source_part' => $sourcePart,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assets_source_part_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SourcePart $sourcePart, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SourcePartType::class, $sourcePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_source_part_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/source_part/edit.html.twig', [
            'source_part' => $sourcePart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_source_part_delete', methods: ['POST'])]
    public function delete(Request $request, SourcePart $sourcePart, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sourcePart->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sourcePart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assets_source_part_index', [], Response::HTTP_SEE_OTHER);
    }
}
