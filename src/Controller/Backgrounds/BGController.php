<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BG;
use App\Form\Backgrounds\BGType;
use App\Repository\Backgrounds\BGRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backgrounds/b/g')]
final class BGController extends AbstractController
{
    #[Route(name: 'app_backgrounds_b_g_index', methods: ['GET'])]
    public function index(BGRepository $bGRepository): Response
    {
        return $this->render('backgrounds/bg/index.html.twig', [
            'b_gs' => $bGRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backgrounds_b_g_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bG = new BG();
        $form = $this->createForm(BGType::class, $bG);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bG);
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg/new.html.twig', [
            'b_g' => $bG,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_show', methods: ['GET'])]
    public function show(BG $bG): Response
    {
        return $this->render('backgrounds/bg/show.html.twig', [
            'b_g' => $bG,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backgrounds_b_g_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BG $bG, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGType::class, $bG);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg/edit.html.twig', [
            'b_g' => $bG,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_delete', methods: ['POST'])]
    public function delete(Request $request, BG $bG, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bG->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bG);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backgrounds_b_g_index', [], Response::HTTP_SEE_OTHER);
    }
}
