<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Alignment;
use App\Form\Assets\AlignmentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/alignment')]
final class AlignmentController extends AbstractController
{
    #[Route('/new', name: 'alignment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $alignment = new Alignment();
        $form = $this->createForm(AlignmentType::class, $alignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($alignment);
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/alignment/new.html.twig', [
            'alignment' => $alignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'alignment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alignment $alignment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlignmentType::class, $alignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/alignment/edit.html.twig', [
            'alignment' => $alignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'alignment_delete', methods: ['POST'])]
    public function delete(Request $request, Alignment $alignment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alignment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($alignment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
    }
}
