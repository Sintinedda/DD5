<?php

namespace App\Controller\Races;

use App\Entity\Races\RaceSkill;
use App\Form\Races\RaceSkillType;
use App\Repository\Races\RaceSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races/race/skill')]
final class RaceSkillController extends AbstractController
{
    #[Route(name: 'app_races_race_skill_index', methods: ['GET'])]
    public function index(RaceSkillRepository $raceSkillRepository): Response
    {
        return $this->render('races/race_skill/index.html.twig', [
            'race_skills' => $raceSkillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_race_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceSkill = new RaceSkill();
        $form = $this->createForm(RaceSkillType::class, $raceSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceSkill);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_skill/new.html.twig', [
            'race_skill' => $raceSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_skill_show', methods: ['GET'])]
    public function show(RaceSkill $raceSkill): Response
    {
        return $this->render('races/race_skill/show.html.twig', [
            'race_skill' => $raceSkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_race_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceSkill $raceSkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSkillType::class, $raceSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_race_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_skill/edit.html.twig', [
            'race_skill' => $raceSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_race_skill_delete', methods: ['POST'])]
    public function delete(Request $request, RaceSkill $raceSkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceSkill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_race_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
