<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Classe;
use App\Entity\Classes\ClasseLevel;
use App\Form\Classes\ClasseLevelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-level')]
final class ClasseLevelController extends AbstractController
{
    #[Route('/classe{id}/new', name: 'classe_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]);
        $classeLevel = new ClasseLevel();
        $form = $this->createForm(ClasseLevelType::class, $classeLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeLevel->setClasse($classe);
            $entityManager->persist($classeLevel);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_level/new.html.twig', [
            'classe_level' => $classeLevel,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit', name: 'classe_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseLevel $classeLevel, EntityManagerInterface $entityManager): Response
    {
        $id = $classeLevel->getClasse()->getId();
        $form = $this->createForm(ClasseLevelType::class, $classeLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_level/edit.html.twig', [
            'classe_level' => $classeLevel,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'classe_level_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseLevel $classeLevel, EntityManagerInterface $entityManager): Response
    {
        $id = $classeLevel->getClasse()->getId();

        if ($this->isCsrfTokenValid('delete'.$classeLevel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
