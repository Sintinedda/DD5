<?php

namespace App\Controller\Backgrounds;

use App\Entity\Construct\Liste;
use App\Entity\Construct\Skill;
use App\Form\Construct\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgliste')]
final class BGListeController extends AbstractController
{
    #[Route('/bg{id}/new', name: 'bgliste_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->setSkill($skill);
            $entityManager->persist($liste);
            $entityManager->flush();
            
            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_liste/new.html.twig', [
            'b_g_liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgliste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_liste/edit.html.twig', [
            'b_g_liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgliste_delete', methods: ['POST'])]
    public function delete(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
