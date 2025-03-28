<?php

namespace App\Controller\Races;

use App\Entity\Construct\Skill;
use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceSubrace;
use App\Form\Construct\SkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/race-skill')]
final class RaceSkillController extends AbstractController
{
    #[Route('/srace{id}/new', name: 'srace_skill_new', methods: ['GET', 'POST'])]
    public function newSrace(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $race = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addRaceSource($race);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_skill/new/srace.html.twig', [
            'skill' => $skill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/new', name: 'ssrace_skill_new', methods: ['GET', 'POST'])]
    public function newSsrace(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $race = $entityManager->getRepository(RaceSubrace::class)->findOneBy(['id' => $id]);
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addRaceSubrace($race);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_skill/new/ssrace.html.twig', [
            'skill' => $skill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}/edit', name: 'srace_skill_edit', methods: ['GET', 'POST'])]
    public function editSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addRaceSource($race);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_skill/edit/srace.html.twig', [
            'skill' => $skill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/{id2}/edit', name: 'ssrace_skill_edit', methods: ['GET', 'POST'])]
    public function editSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSubrace::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addRaceSubrace($race);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_skill/edit/ssrace.html.twig', [
            'skill' => $skill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}', name: 'srace_skill_delete', methods: ['POST'])]
    public function deleteSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->getPayload()->getString('_token'))) {
            $skill->removeRaceSource($race);
            if ($skill->getRaceSources()->count() == 0) {
                $entityManager->remove($skill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/srace{id}/{id2}', name: 'ssrace_skill_delete', methods: ['POST'])]
    public function deleteSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSubrace::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->getPayload()->getString('_token'))) {
            $skill->removeRaceSubrace($race);
            if ($skill->getRaceSubraces()->count() == 0) {
                $entityManager->remove($skill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
