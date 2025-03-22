<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyListe;
use App\Form\Classes\SpecialtyListeType;
use App\Repository\Classes\SpecialtyListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/specialty/liste')]
final class SpecialtyListeController extends AbstractController
{
    #[Route(name: 'app_classes_specialty_liste_index', methods: ['GET'])]
    public function index(SpecialtyListeRepository $specialtyListeRepository): Response
    {
        return $this->render('classes/specialty_liste/index.html.twig', [
            'specialty_listes' => $specialtyListeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_specialty_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialtyListe = new SpecialtyListe();
        $form = $this->createForm(SpecialtyListeType::class, $specialtyListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialtyListe);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_liste/new.html.twig', [
            'specialty_liste' => $specialtyListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_liste_show', methods: ['GET'])]
    public function show(SpecialtyListe $specialtyListe): Response
    {
        return $this->render('classes/specialty_liste/show.html.twig', [
            'specialty_liste' => $specialtyListe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_specialty_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpecialtyListe $specialtyListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialtyListeType::class, $specialtyListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_liste/edit.html.twig', [
            'specialty_liste' => $specialtyListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_liste_delete', methods: ['POST'])]
    public function delete(Request $request, SpecialtyListe $specialtyListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialtyListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialtyListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_specialty_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
