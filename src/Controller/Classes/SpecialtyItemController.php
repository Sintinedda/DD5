<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Specialty;
use App\Entity\Classes\SpecialtyItem;
use App\Form\Classes\SpecialtyItemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialties')]
final class SpecialtyItemController extends AbstractController
{
    #[Route('/spe{id}/new', name: 'specialties_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $spe = $entityManager->getRepository(Specialty::class)->findOneBy(['id' => $id]);
        $classeId = $spe->getClasse()->getId();
        $specialtyItem = new SpecialtyItem();
        $form = $this->createForm(SpecialtyItemType::class, $specialtyItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtyItem->addSpecialty($spe);
            $entityManager->persist($specialtyItem);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $classeId], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_item/new.html.twig', [
            'specialty_item' => $specialtyItem,
            'form' => $form,
            'id' => $classeId
        ]);
    }

    #[Route('/spe{id}/{id2}', name: 'specialties_show', methods: ['GET'])]
    public function show(int $id, int $id2, EntityManagerInterface $em): Response
    {
        $spe = $em->getRepository(Specialty::class)->findOneBy(['id' => $id]);

        return $this->render('classes/specialty_item/show.html.twig', [
            'specialty_item' => $em->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]),
            'id' => $id,
            'id2' => $id2,
            'classeId' => $spe->getClasse()->getId()
        ]);
    }

    #[Route('/spe{id}/{id2}/edit', name: 'specialties_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $spe = $entityManager->getRepository(Specialty::class)->findOneBy(['id' => $id]);
        $specialtyItem = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(SpecialtyItemType::class, $specialtyItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialtyItem->addSpecialty($spe);
            $entityManager->flush();

            return $this->redirectToRoute('specialties_show', ['id' => $id, 'id2' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/specialty_item/edit.html.twig', [
            'specialty_item' => $specialtyItem,
            'form' => $form,
            'id' => $id,
            'id2' => $id2
        ]);
    }

    #[Route('/spe{id}/{id2}', name: 'specialties_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $spe = $entityManager->getRepository(Specialty::class)->findOneBy(['id' => $id]);
        $specialtyItem = $entityManager->getRepository(SpecialtyItem::class)->findOneBy(['id' => $id2]);
        $classeId = $spe->getClasse()->getId();

        if ($this->isCsrfTokenValid('delete'.$specialtyItem->getId(), $request->getPayload()->getString('_token'))) {
            $specialtyItem->removeSpecialty($spe);
            if ($specialtyItem->getSpecialties()->count() == 0) {
                $entityManager->remove($specialtyItem);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $classeId], Response::HTTP_SEE_OTHER);
    }
}
