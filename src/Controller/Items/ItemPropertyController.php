<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemProperty;
use App\Form\Items\ItemPropertyType;
use App\Repository\Items\ItemPropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/items/item/property')]
final class ItemPropertyController extends AbstractController
{
    #[Route(name: 'app_items_item_property_index', methods: ['GET'])]
    public function index(ItemPropertyRepository $itemPropertyRepository): Response
    {
        return $this->render('items/item_property/index.html.twig', [
            'item_properties' => $itemPropertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_item_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemProperty = new ItemProperty();
        $form = $this->createForm(ItemPropertyType::class, $itemProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemProperty);
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_property/new.html.twig', [
            'item_property' => $itemProperty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_property_show', methods: ['GET'])]
    public function show(ItemProperty $itemProperty): Response
    {
        return $this->render('items/item_property/show.html.twig', [
            'item_property' => $itemProperty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_item_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemProperty $itemProperty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemPropertyType::class, $itemProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_property/edit.html.twig', [
            'item_property' => $itemProperty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_property_delete', methods: ['POST'])]
    public function delete(Request $request, ItemProperty $itemProperty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemProperty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemProperty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_item_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
