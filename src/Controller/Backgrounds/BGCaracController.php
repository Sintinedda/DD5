<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BG;
use App\Entity\Backgrounds\BGCarac;
use App\Form\Backgrounds\BGCaracType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgcarac')]
final class BGCaracController extends AbstractController
{
    #[Route('/new/{id}', name: 'bgcarac_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id]);
        $bGCarac = new BGCarac();
        $form = $this->createForm(BGCaracType::class, $bGCarac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGCarac->setBg($bg);
            $entityManager->persist($bGCarac);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_carac/new.html.twig', [
            'b_g_carac' => $bGCarac,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bgcarac_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGCarac $bGCarac, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGCaracType::class, $bGCarac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_carac/edit.html.twig', [
            'b_g_carac' => $bGCarac,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bgcarac_delete', methods: ['POST'])]
    public function delete(Request $request, BGCarac $bGCarac, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGCarac->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGCarac);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
