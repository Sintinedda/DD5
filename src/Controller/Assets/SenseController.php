<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Sense;
use App\Form\Assets\SenseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/sense')]
final class SenseController extends AbstractController
{
    #[Route('/new', name: 'sense_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sense = new Sense();
        $form = $this->createForm(SenseType::class, $sense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sense);
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/sense/new.html.twig', [
            'sense' => $sense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'sense_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sense $sense, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SenseType::class, $sense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/sense/edit.html.twig', [
            'sense' => $sense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sense_delete', methods: ['POST'])]
    public function delete(Request $request, Sense $sense, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sense->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
    }
}
