<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Classe;
use App\Entity\Classes\ClasseSpellcasting;
use App\Form\Classes\ClasseSpellcastingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-spellcasting')]
final class ClasseSpellcastingController extends AbstractController
{
    #[Route('/classe{id}/new', name: 'classe_spellcasting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]);
        $classeSpellcasting = new ClasseSpellcasting();
        $form = $this->createForm(ClasseSpellcastingType::class, $classeSpellcasting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeSpellcasting->setClasse($classe);
            $entityManager->persist($classeSpellcasting);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_spellcasting/new.html.twig', [
            'classe_spellcasting' => $classeSpellcasting,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit', name: 'classe_spellcasting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseSpellcasting $classeSpellcasting, EntityManagerInterface $entityManager): Response
    {
        $id = $classeSpellcasting->getClasse()->getId();
        $form = $this->createForm(ClasseSpellcastingType::class, $classeSpellcasting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_spellcasting/edit.html.twig', [
            'classe_spellcasting' => $classeSpellcasting,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'classe_spellcasting_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseSpellcasting $classeSpellcasting, EntityManagerInterface $entityManager): Response
    {
        $classe = $classeSpellcasting->getClasse();

        if ($this->isCsrfTokenValid('delete'.$classeSpellcasting->getId(), $request->getPayload()->getString('_token'))) {
            $classe->setSpellcasting(NULL);
            $entityManager->remove($classeSpellcasting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $classe->getId()], Response::HTTP_SEE_OTHER);
    }
}
