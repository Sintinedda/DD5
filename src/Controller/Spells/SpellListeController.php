<?php

namespace App\Controller\Spells;

use App\Entity\Spells\SpellListe;
use App\Form\Spells\SpellListeType;
use App\Repository\Spells\SpellListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spells/spell/liste')]
final class SpellListeController extends AbstractController
{
    #[Route(name: 'app_spells_spell_liste_index', methods: ['GET'])]
    public function index(SpellListeRepository $spellListeRepository): Response
    {
        return $this->render('spells/spell_liste/index.html.twig', [
            'spell_listes' => $spellListeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spells_spell_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spellListe = new SpellListe();
        $form = $this->createForm(SpellListeType::class, $spellListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spellListe);
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_liste/new.html.twig', [
            'spell_liste' => $spellListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_liste_show', methods: ['GET'])]
    public function show(SpellListe $spellListe): Response
    {
        return $this->render('spells/spell_liste/show.html.twig', [
            'spell_liste' => $spellListe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spells_spell_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpellListe $spellListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpellListeType::class, $spellListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_liste/edit.html.twig', [
            'spell_liste' => $spellListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_liste_delete', methods: ['POST'])]
    public function delete(Request $request, SpellListe $spellListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spellListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spellListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spells_spell_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
