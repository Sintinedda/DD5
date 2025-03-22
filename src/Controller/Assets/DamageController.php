<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Damage;
use App\Form\Assets\DamageType;
use App\Repository\Assets\DamageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assets/damage')]
final class DamageController extends AbstractController
{
    #[Route(name: 'app_assets_damage_index', methods: ['GET'])]
    public function index(DamageRepository $damageRepository): Response
    {
        return $this->render('assets/damage/index.html.twig', [
            'damages' => $damageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assets_damage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $damage = new Damage();
        $form = $this->createForm(DamageType::class, $damage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($damage);
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_damage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/damage/new.html.twig', [
            'damage' => $damage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_damage_show', methods: ['GET'])]
    public function show(Damage $damage): Response
    {
        return $this->render('assets/damage/show.html.twig', [
            'damage' => $damage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assets_damage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Damage $damage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DamageType::class, $damage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_damage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/damage/edit.html.twig', [
            'damage' => $damage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_damage_delete', methods: ['POST'])]
    public function delete(Request $request, Damage $damage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$damage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($damage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assets_damage_index', [], Response::HTTP_SEE_OTHER);
    }
}
