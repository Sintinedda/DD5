<?php

namespace App\Controller\Assets;

use App\Entity\Assets\CreatureType;
use App\Form\Assets\CreatureTypeType;
use App\Repository\Assets\CreatureTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assets/creature/type')]
final class CreatureTypeController extends AbstractController
{
    #[Route(name: 'app_assets_creature_type_index', methods: ['GET'])]
    public function index(CreatureTypeRepository $creatureTypeRepository): Response
    {
        return $this->render('assets/creature_type/index.html.twig', [
            'creature_types' => $creatureTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assets_creature_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $creatureType = new CreatureType();
        $form = $this->createForm(CreatureTypeType::class, $creatureType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($creatureType);
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_creature_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/creature_type/new.html.twig', [
            'creature_type' => $creatureType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_creature_type_show', methods: ['GET'])]
    public function show(CreatureType $creatureType): Response
    {
        return $this->render('assets/creature_type/show.html.twig', [
            'creature_type' => $creatureType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assets_creature_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CreatureType $creatureType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreatureTypeType::class, $creatureType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assets_creature_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assets/creature_type/edit.html.twig', [
            'creature_type' => $creatureType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assets_creature_type_delete', methods: ['POST'])]
    public function delete(Request $request, CreatureType $creatureType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creatureType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($creatureType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assets_creature_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
