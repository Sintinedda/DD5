<?php

namespace App\Controller\Spells;

use App\Entity\Spells\SpellSchool;
use App\Form\Spells\SpellSchoolType;
use App\Repository\Spells\SpellSchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spells/spell/school')]
final class SpellSchoolController extends AbstractController
{
    #[Route(name: 'app_spells_spell_school_index', methods: ['GET'])]
    public function index(SpellSchoolRepository $spellSchoolRepository): Response
    {
        return $this->render('spells/spell_school/index.html.twig', [
            'spell_schools' => $spellSchoolRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spells_spell_school_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spellSchool = new SpellSchool();
        $form = $this->createForm(SpellSchoolType::class, $spellSchool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spellSchool);
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_school_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_school/new.html.twig', [
            'spell_school' => $spellSchool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_school_show', methods: ['GET'])]
    public function show(SpellSchool $spellSchool): Response
    {
        return $this->render('spells/spell_school/show.html.twig', [
            'spell_school' => $spellSchool,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spells_spell_school_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpellSchool $spellSchool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpellSchoolType::class, $spellSchool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spells_spell_school_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spells/spell_school/edit.html.twig', [
            'spell_school' => $spellSchool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spells_spell_school_delete', methods: ['POST'])]
    public function delete(Request $request, SpellSchool $spellSchool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spellSchool->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spellSchool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spells_spell_school_index', [], Response::HTTP_SEE_OTHER);
    }
}
