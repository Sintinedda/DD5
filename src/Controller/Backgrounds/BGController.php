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

#[Route('/admin/background')]
final class BGController extends AbstractController
{
    #[Route(name: 'background', methods: ['GET'])]
    public function index(BGRepository $bGRepository): Response
    {
        return $this->render('backgrounds/index.html.twig', [
            'b_gs' => $bGRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'background_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bG = new BG();
        $form = $this->createForm(BGType::class, $bG);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bG);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg/new.html.twig', [
            'b_g' => $bG,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'background_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BG $bG, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGType::class, $bG);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg/edit.html.twig', [
            'b_g' => $bG,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'background_delete', methods: ['POST'])]
    public function delete(Request $request, BG $bG, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bG->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bG);
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
