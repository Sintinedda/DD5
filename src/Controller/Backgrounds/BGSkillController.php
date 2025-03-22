<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BGSkill;
use App\Form\Backgrounds\BGSkillType;
use App\Repository\Backgrounds\BGSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backgrounds/b/g/skill')]
final class BGSkillController extends AbstractController
{
    #[Route(name: 'app_backgrounds_b_g_skill_index', methods: ['GET'])]
    public function index(BGSkillRepository $bGSkillRepository): Response
    {
        return $this->render('backgrounds/bg_skill/index.html.twig', [
            'b_g_skills' => $bGSkillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backgrounds_b_g_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bGSkill = new BGSkill();
        $form = $this->createForm(BGSkillType::class, $bGSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bGSkill);
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_skill/new.html.twig', [
            'b_g_skill' => $bGSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_skill_show', methods: ['GET'])]
    public function show(BGSkill $bGSkill): Response
    {
        return $this->render('backgrounds/bg_skill/show.html.twig', [
            'b_g_skill' => $bGSkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backgrounds_b_g_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGSkill $bGSkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BGSkillType::class, $bGSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backgrounds_b_g_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_skill/edit.html.twig', [
            'b_g_skill' => $bGSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backgrounds_b_g_skill_delete', methods: ['POST'])]
    public function delete(Request $request, BGSkill $bGSkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bGSkill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bGSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backgrounds_b_g_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
