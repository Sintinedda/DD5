<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseSkill;
use App\Entity\Classes\ClasseSubskill;
use App\Form\Classes\ClasseSubskillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-subskill')]
final class ClasseSubskillController extends AbstractController
{
    #[Route('/classe{id}/skill{id2}/new', name: 'classe_subskill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(ClasseSkill::class)->findOneBy(['id' => $id2]);
        $classeSubskill = new ClasseSubskill();
        $form = $this->createForm(ClasseSubskillType::class, $classeSubskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeSubskill->setSkill($skill);
            $entityManager->persist($classeSubskill);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/new.html.twig', [
            'classe_subskill' => $classeSubskill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_subskill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeSubskill = $entityManager->getRepository(ClasseSubskill::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ClasseSubskillType::class, $classeSubskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/edit.html.twig', [
            'classe_subskill' => $classeSubskill,
            'form' => $form,
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_subskill_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeSubskill = $entityManager->getRepository(ClasseSubskill::class)->findOneBy(['id' => $id2]);
        
        if ($this->isCsrfTokenValid('delete'.$classeSubskill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeSubskill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
