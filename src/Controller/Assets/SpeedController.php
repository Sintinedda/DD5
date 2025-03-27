<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Speed;
use App\Form\Assets\SpeedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/speed')]
final class SpeedController extends AbstractController
{
    #[Route('/new', name: 'speed_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $speed = new Speed();
        $form = $this->createForm(SpeedType::class, $speed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($speed);
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/speed/new.html.twig', [
            'speed' => $speed,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'speed_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Speed $speed, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpeedType::class, $speed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/speed/edit.html.twig', [
            'speed' => $speed,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'speed_delete', methods: ['POST'])]
    public function delete(Request $request, Speed $speed, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$speed->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($speed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
    }
}
