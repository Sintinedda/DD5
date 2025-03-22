<?php

namespace App\Controller\Items;

use App\Entity\Items\ItemListe;
use App\Form\Items\ItemListeType;
use App\Repository\Items\ItemListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/items/item/liste')]
final class ItemListeController extends AbstractController
{
    #[Route(name: 'app_items_item_liste_index', methods: ['GET'])]
    public function index(ItemListeRepository $itemListeRepository): Response
    {
        return $this->render('items/item_liste/index.html.twig', [
            'item_listes' => $itemListeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_item_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemListe = new ItemListe();
        $form = $this->createForm(ItemListeType::class, $itemListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemListe);
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/new.html.twig', [
            'item_liste' => $itemListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_liste_show', methods: ['GET'])]
    public function show(ItemListe $itemListe): Response
    {
        return $this->render('items/item_liste/show.html.twig', [
            'item_liste' => $itemListe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_item_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemListe $itemListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemListeType::class, $itemListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_items_item_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/edit.html.twig', [
            'item_liste' => $itemListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_item_liste_delete', methods: ['POST'])]
    public function delete(Request $request, ItemListe $itemListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_item_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
