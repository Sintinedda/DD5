<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Source;
use App\Entity\Assets\SourcePart;
use App\Form\Assets\SourcePartType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/source-part')]
final class SourcePartController extends AbstractController
{
    #[Route('/source{id}/new', name: 'source_part_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $source = $entityManager->getRepository(Source::class)->findOneBy(['id' => $id]);
        $sourcePart = new SourcePart();
        $form = $this->createForm(SourcePartType::class, $sourcePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sourcePart->setSource($source);
            $entityManager->persist($sourcePart);
            $entityManager->flush();

            return $this->redirectToRoute('source', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/source_part/new.html.twig', [
            'source_part' => $sourcePart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'source_part_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SourcePart $sourcePart, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SourcePartType::class, $sourcePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('source', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/source_part/edit.html.twig', [
            'source_part' => $sourcePart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'source_part_delete', methods: ['POST'])]
    public function delete(Request $request, SourcePart $sourcePart, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sourcePart->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sourcePart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('source', [], Response::HTTP_SEE_OTHER);
    }
}
