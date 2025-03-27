<?php

namespace App\Controller\Monsters;

use App\Entity\Monsters\SB;
use App\Entity\Monsters\SBSkill;
use App\Entity\Monsters\SBSpecialty;
use App\Form\Monsters\SBSpecialtyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/monster-specialty')]
final class SBSpecialtyController extends AbstractController
{
    #[Route('/sb{id}/skill{id2}/new', name: 'monster_specialty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $sb = $entityManager->getRepository(SB::class)->findOneBy(['id' => $id]);
        $skill = $entityManager->getRepository(SBSkill::class)->findOneBy(['id' => $id2]);
        $sBSpecialty = new SBSpecialty();
        $form = $this->createForm(SBSpecialtyType::class, $sBSpecialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sBSpecialty->setMonster($sb)->setSkill($skill);
            $entityManager->persist($sBSpecialty);
            $entityManager->flush();

            return $this->redirectToRoute('monster_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_specialty/new.html.twig', [
            's_b_specialty' => $sBSpecialty,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/sb{id}/{id2}/edit', name: 'monster_specialty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $sBSpecialty = $entityManager->getRepository(SBSpecialty::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SBSpecialtyType::class, $sBSpecialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('monster_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_specialty/edit.html.twig', [
            's_b_specialty' => $sBSpecialty,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/sb{id}/{id2}', name: 'monster_specialty_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $sBSpecialty = $entityManager->getRepository(SBSpecialty::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$sBSpecialty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sBSpecialty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('monster_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
