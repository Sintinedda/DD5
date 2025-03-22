<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGListe;
use App\Form\Backgrounds\BGListeType;
use App\Repository\Backgrounds\BGListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backgrounds/b/g/liste')]
final class BGListeController extends AbstractController
{
    #[Route(name: 'app_backgrounds_b_g_liste_index', methods: ['GET'])]
    public function index(BGListeRepository $bGListeRepository): Response
    {
        return $this->render('backgrounds/bg_liste/index.html.twig', [
            'b_g_listes' => $bGListeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backgrounds_b_g_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bGListe = new BGListe();
        $form = $this->createForm(BGListeType::class, $bGListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bGListe);
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_liste/new.html.twig', [
            'b_g_liste' => $bGListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_liste_show', methods: ['GET'])]
    public function show(BGListe $bGListe): Response
    {
        return $this->render('backgrounds/bg_liste/show.html.twig', [
            'b_g_liste' => $bGListe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backgrounds_b_g_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGListe $bGListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGListeType::class, $bGListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_liste/edit.html.twig', [
            'b_g_liste' => $bGListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_liste_delete', methods: ['POST'])]
    public function delete(Request $request, BGListe $bGListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backgrounds_b_g_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
