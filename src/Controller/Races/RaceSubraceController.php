<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceSubrace;
use App\Form\Races\RaceSubraceType;
use App\Repository\Races\RaceSubraceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races/race/subrace')]
final class RaceSubraceController extends AbstractController
{
    #[Route(name: 'app_races_race_subrace_index', methods: ['GET'])]
    public function index(RaceSubraceRepository $raceSubraceRepository): Response
    {
        return $this->render('races/race_subrace/index.html.twig', [
            'race_subraces' => $raceSubraceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_race_subrace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceSubrace = new RaceSubrace();
        $form = $this->createForm(RaceSubraceType::class, $raceSubrace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceSubrace);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_subrace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_subrace/new.html.twig', [
            'race_subrace' => $raceSubrace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_subrace_show', methods: ['GET'])]
    public function show(RaceSubrace $raceSubrace): Response
    {
        return $this->render('races/race_subrace/show.html.twig', [
            'race_subrace' => $raceSubrace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_race_subrace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceSubrace $raceSubrace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSubraceType::class, $raceSubrace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_subrace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_subrace/edit.html.twig', [
            'race_subrace' => $raceSubrace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_subrace_delete', methods: ['POST'])]
    public function delete(Request $request, RaceSubrace $raceSubrace, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceSubrace->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSubrace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_race_subrace_index', [], Response::HTTP_SEE_OTHER);
    }
}
