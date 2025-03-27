<?php

namespace App\Controller\Assets;

use App\Entity\Assets\School;
use App\Form\Assets\SchoolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/school')]
final class SchoolController extends AbstractController
{
    #[Route('/new', name: 'school_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($school);
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/school/new.html.twig', [
            'school' => $school,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'school_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, School $school, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/school/edit.html.twig', [
            'school' => $school,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'school_delete', methods: ['POST'])]
    public function delete(Request $request, School $school, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$school->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($school);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
    }
}
