<?php

namespace App\Controller\Classes;

use App\Entity\Classes\SpecialtyListe;
use App\Entity\Classes\SpecialtySkill;
use App\Form\Classes\SpecialtyListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialty-liste')]
final class SpecialtyListeController extends AbstractController
{
    #[Route('/spe{id}/item{id2}/skill{id3}/new', name: 'specialty_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $skill = $entityManager->getRepository(SpecialtySkill::class)->findOneBy(['id' => $id3]);
        $specialtyListe = new SpecialtyListe();
        $form = $this->createForm(SpecialtyListeType::class, $specialtyListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtyListe->setSkill($skill);
            $entityManager->persist($specialtyListe);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_liste/new.html.twig', [
            'specialty_liste' => $specialtyListe,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}/edit', name: 'specialty_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $specialtyListe = $entityManager->getRepository(SpecialtyListe::class)->findOneBy(['id' => $id3]);
        $form = $this->createForm(SpecialtyListeType::class, $specialtyListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_liste/edit.html.twig', [
            'specialty_liste' => $specialtyListe,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/item{id2}/{id3}', name: 'specialty_liste_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2, int $id3): Response
    {
        $specialtyListe = $entityManager->getRepository(SpecialtyListe::class)->findOneBy(['id' => $id3]);
        
        if ($this->isCsrfTokenValid('delete'.$specialtyListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialtyListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
    }
}
