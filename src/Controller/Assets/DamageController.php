<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Damage;
use App\Form\Assets\DamageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/damage')]
final class DamageController extends AbstractController
{
    #[Route('/new', name: 'damage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $damage = new Damage();
        $form = $this->createForm(DamageType::class, $damage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($damage);
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/damage/new.html.twig', [
            'damage' => $damage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'damage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Damage $damage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DamageType::class, $damage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/damage/edit.html.twig', [
            'damage' => $damage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'damage_delete', methods: ['POST'])]
    public function delete(Request $request, Damage $damage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$damage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($damage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assets', [], Response::HTTP_SEE_OTHER);
    }
}
