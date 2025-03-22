<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceSource;
use App\Form\Races\RaceSourceType;
use App\Repository\Races\RaceSourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races/race/source')]
final class RaceSourceController extends AbstractController
{
    #[Route(name: 'app_races_race_source_index', methods: ['GET'])]
    public function index(RaceSourceRepository $raceSourceRepository): Response
    {
        return $this->render('races/race_source/index.html.twig', [
            'race_sources' => $raceSourceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_race_source_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceSource = new RaceSource();
        $form = $this->createForm(RaceSourceType::class, $raceSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceSource);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_source/new.html.twig', [
            'race_source' => $raceSource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_source_show', methods: ['GET'])]
    public function show(RaceSource $raceSource): Response
    {
        return $this->render('races/race_source/show.html.twig', [
            'race_source' => $raceSource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_race_source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceSource $raceSource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSourceType::class, $raceSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_source/edit.html.twig', [
            'race_source' => $raceSource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_source_delete', methods: ['POST'])]
    public function delete(Request $request, RaceSource $raceSource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceSource->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_race_source_index', [], Response::HTTP_SEE_OTHER);
    }
}
