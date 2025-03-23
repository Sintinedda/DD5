<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Source;
use App\Form\Assets\SourceType;
use App\Repository\Assets\SourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/source')]
final class SourceController extends AbstractController
{
    #[Route(name: 'source', methods: ['GET'])]
    public function index(SourceRepository $sourceRepository): Response
    {
        return $this->render('assets/source/index.html.twig', [
            'sources' => $sourceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'source_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $source = new Source();
        $form = $this->createForm(SourceType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($source);
            $entityManager->flush();

            return $this->redirectToRoute('source', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/source/new.html.twig', [
            'source' => $source,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Source $source, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SourceType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('source', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/source/edit.html.twig', [
            'source' => $source,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'source_delete', methods: ['POST'])]
    public function delete(Request $request, Source $source, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$source->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($source);
            $entityManager->flush();
        }

        return $this->redirectToRoute('source', [], Response::HTTP_SEE_OTHER);
    }
}
