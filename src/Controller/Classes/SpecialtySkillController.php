<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtySkill;
use App\Form\Classes\SpecialtySkillType;
use App\Repository\Classes\SpecialtySkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/specialty/skill')]
final class SpecialtySkillController extends AbstractController
{
    #[Route(name: 'app_classes_specialty_skill_index', methods: ['GET'])]
    public function index(SpecialtySkillRepository $specialtySkillRepository): Response
    {
        return $this->render('classes/specialty_skill/index.html.twig', [
            'specialty_skills' => $specialtySkillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_specialty_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialtySkill = new SpecialtySkill();
        $form = $this->createForm(SpecialtySkillType::class, $specialtySkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialtySkill);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_skill/new.html.twig', [
            'specialty_skill' => $specialtySkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_skill_show', methods: ['GET'])]
    public function show(SpecialtySkill $specialtySkill): Response
    {
        return $this->render('classes/specialty_skill/show.html.twig', [
            'specialty_skill' => $specialtySkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_specialty_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpecialtySkill $specialtySkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialtySkillType::class, $specialtySkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_skill/edit.html.twig', [
            'specialty_skill' => $specialtySkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_skill_delete', methods: ['POST'])]
    public function delete(Request $request, SpecialtySkill $specialtySkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialtySkill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialtySkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_specialty_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
