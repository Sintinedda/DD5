<?php

namespace App\Controller\Monsters;

use App\Entity\Monsters\SBSkill;
use App\Form\Monsters\SBSkillType;
use App\Repository\Monsters\SBSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/monsters/s/b/skill')]
final class SBSkillController extends AbstractController
{
    #[Route(name: 'app_monsters_s_b_skill_index', methods: ['GET'])]
    public function index(SBSkillRepository $sBSkillRepository): Response
    {
        return $this->render('monsters/sb_skill/index.html.twig', [
            's_b_skills' => $sBSkillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_monsters_s_b_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sBSkill = new SBSkill();
        $form = $this->createForm(SBSkillType::class, $sBSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sBSkill);
            $entityManager->flush();

            return $this->redirectToRoute('app_monsters_s_b_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_skill/new.html.twig', [
            's_b_skill' => $sBSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monsters_s_b_skill_show', methods: ['GET'])]
    public function show(SBSkill $sBSkill): Response
    {
        return $this->render('monsters/sb_skill/show.html.twig', [
            's_b_skill' => $sBSkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_monsters_s_b_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SBSkill $sBSkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SBSkillType::class, $sBSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_monsters_s_b_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_skill/edit.html.twig', [
            's_b_skill' => $sBSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monsters_s_b_skill_delete', methods: ['POST'])]
    public function delete(Request $request, SBSkill $sBSkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sBSkill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sBSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_monsters_s_b_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
