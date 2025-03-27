<?php

namespace App\Controller\Monsters;

use App\Entity\Monsters\SB;
use App\Entity\Monsters\SBSkill;
use App\Form\Monsters\SBSkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/monster-skill')]
final class SBSkillController extends AbstractController
{
    #[Route('/sb{id}/new', name: 'monster_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $sb = $entityManager->getRepository(SB::class)->findOneBy(['id' => $id]);
        $sBSkill = new SBSkill();
        $form = $this->createForm(SBSkillType::class, $sBSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sBSkill->addMonster($sb);
            $entityManager->persist($sBSkill);
            $entityManager->flush();

            return $this->redirectToRoute('monster_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_skill/new.html.twig', [
            's_b_skill' => $sBSkill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/sb{id}/{id2}/edit', name: 'monster_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $sb = $entityManager->getRepository(SB::class)->findOneBy(['id' => $id]);
        $sBSkill = $entityManager->getRepository(SBSkill::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SBSkillType::class, $sBSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sBSkill->addMonster($sb);
            $entityManager->flush();

            return $this->redirectToRoute('monster_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_skill/edit.html.twig', [
            's_b_skill' => $sBSkill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/sb{id}/{id2}', name: 'monster_skill_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $sb = $entityManager->getRepository(SB::class)->findOneBy(['id' => $id]);
        $sBSkill = $entityManager->getRepository(SBSkill::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$sBSkill->getId(), $request->getPayload()->getString('_token'))) {
            $sBSkill->removeMonster($sb);
            if ($sBSkill->getMonsters == 0) {
                $entityManager->remove($sBSkill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('monster_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
