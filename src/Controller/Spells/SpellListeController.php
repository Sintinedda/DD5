<?php

namespace App\Controller\Spells;

use App\Entity\Construct\Liste;
use App\Entity\Spells\Spell;
use App\Form\Construct\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/spell-liste')]
final class SpellListeController extends AbstractController
{
    #[Route('/spell{id}/new', name: 'spell_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $spell = $entityManager->getRepository(Spell::class)->findOneBy(['id' => $id]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->setSpell($spell);
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_liste/new.html.twig', [
            'spell_liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'spell_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_liste/edit.html.twig', [
            'spell_liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'spell_liste_delete', methods: ['POST'])]
    public function delete(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spells', [], Response::HTTP_SEE_OTHER);
    }
}
