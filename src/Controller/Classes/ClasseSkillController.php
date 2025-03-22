<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseSkill;
use App\Form\Classes\ClasseSkillType;
use App\Repository\Classes\ClasseSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/skill')]
final class ClasseSkillController extends AbstractController
{
    #[Route(name: 'app_classes_classe_skill_index', methods: ['GET'])]
    public function index(ClasseSkillRepository $classeSkillRepository): Response
    {
        return $this->render('classes/classe_skill/index.html.twig', [
            'classe_skills' => $classeSkillRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeSkill = new ClasseSkill();
        $form = $this->createForm(ClasseSkillType::class, $classeSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeSkill);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_skill/new.html.twig', [
            'classe_skill' => $classeSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_skill_show', methods: ['GET'])]
    public function show(ClasseSkill $classeSkill): Response
    {
        return $this->render('classes/classe_skill/show.html.twig', [
            'classe_skill' => $classeSkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseSkill $classeSkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseSkillType::class, $classeSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_skill/edit.html.twig', [
            'classe_skill' => $classeSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_skill_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseSkill $classeSkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeSkill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
