<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGCarac;
use App\Form\Backgrounds\BGCaracType;
use App\Repository\Backgrounds\BGCaracRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backgrounds/b/g/carac')]
final class BGCaracController extends AbstractController
{
    #[Route(name: 'app_backgrounds_b_g_carac_index', methods: ['GET'])]
    public function index(BGCaracRepository $bGCaracRepository): Response
    {
        return $this->render('backgrounds/bg_carac/index.html.twig', [
            'b_g_caracs' => $bGCaracRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backgrounds_b_g_carac_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bGCarac = new BGCarac();
        $form = $this->createForm(BGCaracType::class, $bGCarac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bGCarac);
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_carac_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_carac/new.html.twig', [
            'b_g_carac' => $bGCarac,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_carac_show', methods: ['GET'])]
    public function show(BGCarac $bGCarac): Response
    {
        return $this->render('backgrounds/bg_carac/show.html.twig', [
            'b_g_carac' => $bGCarac,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backgrounds_b_g_carac_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGCarac $bGCarac, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGCaracType::class, $bGCarac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_carac_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_carac/edit.html.twig', [
            'b_g_carac' => $bGCarac,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_carac_delete', methods: ['POST'])]
    public function delete(Request $request, BGCarac $bGCarac, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGCarac->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGCarac);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backgrounds_b_g_carac_index', [], Response::HTTP_SEE_OTHER);
    }
}
