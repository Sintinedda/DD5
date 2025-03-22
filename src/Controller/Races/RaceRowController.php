<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceRow;
use App\Form\Races\RaceRowType;
use App\Repository\Races\RaceRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races/race/row')]
final class RaceRowController extends AbstractController
{
    #[Route(name: 'app_races_race_row_index', methods: ['GET'])]
    public function index(RaceRowRepository $raceRowRepository): Response
    {
        return $this->render('races/race_row/index.html.twig', [
            'race_rows' => $raceRowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_race_row_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceRow = new RaceRow();
        $form = $this->createForm(RaceRowType::class, $raceRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceRow);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_row/new.html.twig', [
            'race_row' => $raceRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_row_show', methods: ['GET'])]
    public function show(RaceRow $raceRow): Response
    {
        return $this->render('races/race_row/show.html.twig', [
            'race_row' => $raceRow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_race_row_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceRow $raceRow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceRowType::class, $raceRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_row_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_row/edit.html.twig', [
            'race_row' => $raceRow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_row_delete', methods: ['POST'])]
    public function delete(Request $request, RaceRow $raceRow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceRow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceRow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_race_row_index', [], Response::HTTP_SEE_OTHER);
    }
}
