<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Feat;
use App\Form\Assets\FeatType;
use App\Repository\Assets\FeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assets/feat')]
final class FeatController extends AbstractController
{
    #[Route(name: 'app_assets_feat_index', methods: ['GET'])]
    public function index(FeatRepository $featRepository): Response
    {
        return $this->render('assets/feat/index.html.twig', [
            'feats' => $featRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assets_feat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feat = new Feat();
        $form = $this->createForm(FeatType::class, $feat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($feat);
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_feat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/feat/new.html.twig', [
            'feat' => $feat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_feat_show', methods: ['GET'])]
    public function show(Feat $feat): Response
    {
        return $this->render('assets/feat/show.html.twig', [
            'feat' => $feat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assets_feat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Feat $feat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FeatType::class, $feat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_feat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/feat/edit.html.twig', [
            'feat' => $feat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_feat_delete', methods: ['POST'])]
    public function delete(Request $request, Feat $feat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($feat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assets_feat_index', [], Response::HTTP_SEE_OTHER);
    }
}
