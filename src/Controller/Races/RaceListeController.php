<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceListe;
use App\Form\Races\RaceListeType;
use App\Repository\Races\RaceListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races/race/liste')]
final class RaceListeController extends AbstractController
{
    #[Route(name: 'app_races_race_liste_index', methods: ['GET'])]
    public function index(RaceListeRepository $raceListeRepository): Response
    {
        return $this->render('races/race_liste/index.html.twig', [
            'race_listes' => $raceListeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_race_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceListe = new RaceListe();
        $form = $this->createForm(RaceListeType::class, $raceListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceListe);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_liste/new.html.twig', [
            'race_liste' => $raceListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_liste_show', methods: ['GET'])]
    public function show(RaceListe $raceListe): Response
    {
        return $this->render('races/race_liste/show.html.twig', [
            'race_liste' => $raceListe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_race_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceListe $raceListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceListeType::class, $raceListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_liste/edit.html.twig', [
            'race_liste' => $raceListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_liste_delete', methods: ['POST'])]
    public function delete(Request $request, RaceListe $raceListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_race_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
