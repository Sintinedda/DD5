<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyItem;
use App\Entity\Classes\SpecialtySkill;
use App\Form\Classes\SpecialtySkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialty-skill')]
final class SpecialtySkillController extends AbstractController
{
    #[Route('/spe{id}/item{id2}/new', name: 'specialty_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $spe = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $specialtySkill = new SpecialtySkill();
        $form = $this->createForm(SpecialtySkillType::class, $specialtySkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtySkill->addSpecialty($spe);
            $entityManager->persist($specialtySkill);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_skill/new.html.twig', [
            'specialty_skill' => $specialtySkill,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}/edit', name: 'specialty_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $spe = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $specialtySkill = $entityManager->getRepository(SpecialtySkill::class)->findOneBy(['id' => $id3]);
        $form = $this->createForm(SpecialtySkillType::class, $specialtySkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtySkill->addSpecialty($spe);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_skill/edit.html.twig', [
            'specialty_skill' => $specialtySkill,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}', name: 'specialty_skill_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $spe = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $specialtySkill = $entityManager->getRepository(SpecialtySkill::class)->findOneBy(['id' => $id3]);

        if ($this->isCsrfTokenValid('delete'.$specialtySkill->getId(), $request->getPayload()->getString('_token'))) {
            $specialtySkill->removeSpecialty($spe);
            if ($specialtySkill->getSpecialties()->count() == 0) {
                $entityManager->remove($specialtySkill);    
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
    }
}
