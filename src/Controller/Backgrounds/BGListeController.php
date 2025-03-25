<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGListe;
use App\Entity\Backgrounds\BGSkill;
use App\Form\Backgrounds\BGListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgliste')]
final class BGListeController extends AbstractController
{
    #[Route('/new/{id}', name: 'bgliste_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = $entityManager->getRepository(BGSkill::class)->findOneBy(['id' => $id]);
        $bGListe = new BGListe();
        $form = $this->createForm(BGListeType::class, $bGListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGListe->setSkill($skill);
            $entityManager->persist($bGListe);
            $entityManager->flush();
            
            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_liste/new.html.twig', [
            'b_g_liste' => $bGListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgliste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGListe $bGListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGListeType::class, $bGListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_liste/edit.html.twig', [
            'b_g_liste' => $bGListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgliste_delete', methods: ['POST'])]
    public function delete(Request $request, BGListe $bGListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
