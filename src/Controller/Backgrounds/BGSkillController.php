<?php

namespace App\Controller\Backgrounds;

use App\Entity\Backgrounds\BG;
use App\Entity\Construct\Skill;
use App\Form\Construct\SkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bgskill')]
final class BGSkillController extends AbstractController
{
    #[Route('/bg{id}/new', name: 'bgskill_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id]);
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addBg($bg);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_skill/new.html.twig', [
            'b_g_skill' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/bg{id}/{id2}/edit', name: 'bgskill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addBg($bg);
            $entityManager->flush();

            return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backgrounds/bg_skill/edit.html.twig', [
            'b_g_skill' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/bg{id}/{id2}', name: 'bgskill_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $bg = $entityManager->getRepository(BG::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->getPayload()->getString('_token'))) {
            $skill->removeBg($bg);
            if ($skill->getBgs()->count() == 0) {
                $entityManager->remove($skill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('background', [], Response::HTTP_SEE_OTHER);
    }
}
