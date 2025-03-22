<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Specialty;
use App\Form\Classes\SpecialtyType;
use App\Repository\Classes\SpecialtyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/specialty')]
final class SpecialtyController extends AbstractController
{
    #[Route(name: 'app_classes_specialty_index', methods: ['GET'])]
    public function index(SpecialtyRepository $specialtyRepository): Response
    {
        return $this->render('classes/specialty/index.html.twig', [
            'specialties' => $specialtyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_specialty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialty = new Specialty();
        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialty);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty/new.html.twig', [
            'specialty' => $specialty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_show', methods: ['GET'])]
    public function show(Specialty $specialty): Response
    {
        return $this->render('classes/specialty/show.html.twig', [
            'specialty' => $specialty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_specialty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialty $specialty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_specialty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty/edit.html.twig', [
            'specialty' => $specialty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_specialty_delete', methods: ['POST'])]
    public function delete(Request $request, Specialty $specialty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_specialty_index', [], Response::HTTP_SEE_OTHER);
    }
}
