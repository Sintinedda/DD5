<?php

namespace App\Controller\Monsters;

use App\Entity\Monsters\SBSpecialty;
use App\Form\Monsters\SBSpecialtyType;
use App\Repository\Monsters\SBSpecialtyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/monsters/s/b/specialty')]
final class SBSpecialtyController extends AbstractController
{
    #[Route(name: 'app_monsters_s_b_specialty_index', methods: ['GET'])]
    public function index(SBSpecialtyRepository $sBSpecialtyRepository): Response
    {
        return $this->render('monsters/sb_specialty/index.html.twig', [
            's_b_specialties' => $sBSpecialtyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_monsters_s_b_specialty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sBSpecialty = new SBSpecialty();
        $form = $this->createForm(SBSpecialtyType::class, $sBSpecialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sBSpecialty);
            $entityManager->flush();

            return $this->redirectToRoute('app_monsters_s_b_specialty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_specialty/new.html.twig', [
            's_b_specialty' => $sBSpecialty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monsters_s_b_specialty_show', methods: ['GET'])]
    public function show(SBSpecialty $sBSpecialty): Response
    {
        return $this->render('monsters/sb_specialty/show.html.twig', [
            's_b_specialty' => $sBSpecialty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_monsters_s_b_specialty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SBSpecialty $sBSpecialty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SBSpecialtyType::class, $sBSpecialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_monsters_s_b_specialty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb_specialty/edit.html.twig', [
            's_b_specialty' => $sBSpecialty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monsters_s_b_specialty_delete', methods: ['POST'])]
    public function delete(Request $request, SBSpecialty $sBSpecialty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sBSpecialty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sBSpecialty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_monsters_s_b_specialty_index', [], Response::HTTP_SEE_OTHER);
    }
}
