<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Classe;
use App\Entity\Classes\Specialty;
use App\Form\Classes\SpecialtyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialty')]
final class SpecialtyController extends AbstractController
{
    #[Route('/classe{id}/new', name: 'specialty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]);
        $specialty = new Specialty();
        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialty->setClasse($classe);
            $entityManager->persist($specialty);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty/new.html.twig', [
            'specialty' => $specialty,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit', name: 'specialty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialty $specialty, EntityManagerInterface $entityManager): Response
    {
        $id = $specialty->getClasse()->getId();
        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty/edit.html.twig', [
            'specialty' => $specialty,
            'form' => $form,
             'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'specialty_delete', methods: ['POST'])]
    public function delete(Request $request, Specialty $specialty, EntityManagerInterface $entityManager): Response
    {
        $classe = $specialty->getClasse();

        if ($this->isCsrfTokenValid('delete'.$specialty->getId(), $request->getPayload()->getString('_token'))) {
            $classe->setSpecialty(NULL);
            $entityManager->remove($specialty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $classe->getId()], Response::HTTP_SEE_OTHER);
    }
}
