<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Alignment;
use App\Form\Assets\AlignmentType;
use App\Repository\Assets\AlignmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assets/alignment')]
final class AlignmentController extends AbstractController
{
    #[Route(name: 'app_assets_alignment_index', methods: ['GET'])]
    public function index(AlignmentRepository $alignmentRepository): Response
    {
        return $this->render('assets/alignment/index.html.twig', [
            'alignments' => $alignmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assets_alignment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $alignment = new Alignment();
        $form = $this->createForm(AlignmentType::class, $alignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($alignment);
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_alignment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/alignment/new.html.twig', [
            'alignment' => $alignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_alignment_show', methods: ['GET'])]
    public function show(Alignment $alignment): Response
    {
        return $this->render('assets/alignment/show.html.twig', [
            'alignment' => $alignment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assets_alignment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alignment $alignment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlignmentType::class, $alignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_alignment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/alignment/edit.html.twig', [
            'alignment' => $alignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_alignment_delete', methods: ['POST'])]
    public function delete(Request $request, Alignment $alignment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alignment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($alignment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assets_alignment_index', [], Response::HTTP_SEE_OTHER);
    }
}
