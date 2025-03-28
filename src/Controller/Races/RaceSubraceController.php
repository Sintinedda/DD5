<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceSubrace;
use App\Form\Races\RaceSubraceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/ssrace')]
final class RaceSubraceController extends AbstractController
{
    #[Route('srace{id}/new', name: 'ssrace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $srace = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $raceSubrace = new RaceSubrace();
        $form = $this->createForm(RaceSubraceType::class, $raceSubrace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $raceSubrace->setSource($srace);
            $entityManager->persist($raceSubrace);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $raceSubrace->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_subrace/new.html.twig', [
            'race_subrace' => $raceSubrace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'ssrace_show', methods: ['GET'])]
    public function show(RaceSubrace $raceSubrace): Response
    {
        return $this->render('races/race_subrace/show.html.twig', [
            'race_subrace' => $raceSubrace,
        ]);
    }

    #[Route('/{id}/edit', name: 'ssrace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceSubrace $raceSubrace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSubraceType::class, $raceSubrace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $raceSubrace->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_subrace/edit.html.twig', [
            'race_subrace' => $raceSubrace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'ssrace_delete', methods: ['POST'])]
    public function delete(Request $request, RaceSubrace $raceSubrace, EntityManagerInterface $entityManager): Response
    {
        $id = $raceSubrace->getSource()->getId();
        if ($this->isCsrfTokenValid('delete'.$raceSubrace->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSubrace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
