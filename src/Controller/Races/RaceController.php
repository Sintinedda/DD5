<?php

namespace App\Controller\Races;

use App\Entity\Races\Race;
use App\Form\Races\RaceType;
use App\Repository\Races\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/race')]
final class RaceController extends AbstractController
{
    #[Route(name: 'races', methods: ['GET'])]
    public function index(RaceRepository $raceRepository): Response
    {
        return $this->render('races/race/index.html.twig', [
            'races' => $raceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'race_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $race = new Race();
        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($race);
            $entityManager->flush();

            return $this->redirectToRoute('race_show', ['id' => $race->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race/new.html.twig', [
            'race' => $race,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'race_show', methods: ['GET'])]
    public function show(Race $race): Response
    {
        return $this->render('races/race/show.html.twig', [
            'race' => $race,
        ]);
    }

    #[Route('/{id}/edit', name: 'race_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Race $race, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('race_show', ['id' => $race->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race/edit.html.twig', [
            'race' => $race,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'race_delete', methods: ['POST'])]
    public function delete(Request $request, Race $race, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$race->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($race);
            $entityManager->flush();
        }

        return $this->redirectToRoute('races', [], Response::HTTP_SEE_OTHER);
    }
}
