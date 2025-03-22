<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceTable;
use App\Form\Races\RaceTableType;
use App\Repository\Races\RaceTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races/race/table')]
final class RaceTableController extends AbstractController
{
    #[Route(name: 'app_races_race_table_index', methods: ['GET'])]
    public function index(RaceTableRepository $raceTableRepository): Response
    {
        return $this->render('races/race_table/index.html.twig', [
            'race_tables' => $raceTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_race_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTable = new RaceTable();
        $form = $this->createForm(RaceTableType::class, $raceTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/new.html.twig', [
            'race_table' => $raceTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_table_show', methods: ['GET'])]
    public function show(RaceTable $raceTable): Response
    {
        return $this->render('races/race_table/show.html.twig', [
            'race_table' => $raceTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_race_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceTable $raceTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceTableType::class, $raceTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/edit.html.twig', [
            'race_table' => $raceTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_table_delete', methods: ['POST'])]
    public function delete(Request $request, RaceTable $raceTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_race_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
