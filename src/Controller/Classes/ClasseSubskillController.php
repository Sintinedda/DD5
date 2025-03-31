<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Classe;
use App\Entity\Construct\Skill;
use App\Entity\Construct\Subskill;
use App\Form\Construct\SubskillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-subskill')]
final class ClasseSubskillController extends AbstractController
{
    #[Route('/classe{id}/new', name: 'classe_csubskill_new', methods: ['GET', 'POST'])]
    public function newClasse(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]);
        $subskill = new Subskill();
        $form = $this->createForm(SubskillType::class, $subskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subskill->setClasse($classe);
            $entityManager->persist($subskill);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/new.html.twig', [
            'classe_subskill' => $subskill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/skill{id2}/new', name: 'classe_subskill_new', methods: ['GET', 'POST'])]
    public function newSkill(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $subskill = new Subskill();
        $form = $this->createForm(SubskillType::class, $subskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subskill->setSkill($skill);
            $entityManager->persist($subskill);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/new.html.twig', [
            'classe_subskill' => $subskill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_subskill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $subskill = $entityManager->getRepository(Subskill::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SubskillType::class, $subskill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_subskill/edit.html.twig', [
            'classe_subskill' => $subskill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_subskill_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $subskill = $entityManager->getRepository(Subskill::class)->findOneBy(['id' => $id2]);
        
        if ($this->isCsrfTokenValid('delete'.$subskill->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subskill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
