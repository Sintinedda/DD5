<?php

namespace App\Controller\Races;

use App\Entity\Races\Race;
use App\Entity\Races\RaceSource;
use App\Form\Races\RaceSourceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admini/srace')]
final class RaceSourceController extends AbstractController
{
    #[Route('race{id}/new', name: 'srace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $race = $entityManager->getRepository(Race::class)->findOneBy(['id' => $id]);
        $raceSource = new RaceSource();
        $form = $this->createForm(RaceSourceType::class, $raceSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $raceSource->setRace($race);
            $entityManager->persist($raceSource);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $raceSource->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_source/new.html.twig', [
            'race_source' => $raceSource,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'srace_show', methods: ['GET'])]
    public function show(RaceSource $raceSource): Response
    {
        return $this->render('races/race_source/show.html.twig', [
            'race_source' => $raceSource,
        ]);
    }

    #[Route('/{id}/edit', name: 'srace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceSource $raceSource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSourceType::class, $raceSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $raceSource->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_source/edit.html.twig', [
            'race_source' => $raceSource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'srace_delete', methods: ['POST'])]
    public function delete(Request $request, RaceSource $raceSource, EntityManagerInterface $entityManager): Response
    {
        $id = $raceSource->getRace()->getId();

        if ($this->isCsrfTokenValid('delete'.$raceSource->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('race_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
