<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BG;
use App\Entity\Backgrounds\BGSkill;
use App\Form\Backgrounds\BGSkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgskill')]
final class BGSkillController extends AbstractController
{
    #[Route('/new/{id}', name: 'bgskill_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id]);
        $bGSkill = new BGSkill();
        $form = $this->createForm(BGSkillType::class, $bGSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGSkill->addBG($bg);
            $entityManager->persist($bGSkill);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_skill/new.html.twig', [
            'b_g_skill' => $bGSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/{id2}', name: 'bgskill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BGSkill $bGSkill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(BGSkillType::class, $bGSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bGSkill->addBG($bg);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_skill/edit.html.twig', [
            'b_g_skill' => $bGSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/{id2}', name: 'bgskill_delete', methods: ['POST'])]
    public function delete(Request $request, BGSkill $bGSkill, EntityManagerInterface $entityManager, int $id2): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$bGSkill->getId(), $request->getPayload()->getString('_token'))) {
            $bGSkill->removeBG($bg);
            if ($bGSkill->getBGs()->count() == 0) {
                $entityManager->remove($bGSkill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
