<?php

namespace App\Controller\Monsters;

use App\Entity\Monsters\SB;
use App\Form\Monsters\SBType;
use App\Repository\Monsters\SBRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/monsters/s/b')]
final class SBController extends AbstractController
{
    #[Route(name: 'app_monsters_s_b_index', methods: ['GET'])]
    public function index(SBRepository $sBRepository): Response
    {
        return $this->render('monsters/sb/index.html.twig', [
            's_bs' => $sBRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_monsters_s_b_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sB = new SB();
        $form = $this->createForm(SBType::class, $sB);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sB);
            $entityManager->flush();

            return $this->redirectToRoute('app_monsters_s_b_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb/new.html.twig', [
            's_b' => $sB,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monsters_s_b_show', methods: ['GET'])]
    public function show(SB $sB): Response
    {
        return $this->render('monsters/sb/show.html.twig', [
            's_b' => $sB,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_monsters_s_b_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SB $sB, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SBType::class, $sB);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_monsters_s_b_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb/edit.html.twig', [
            's_b' => $sB,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monsters_s_b_delete', methods: ['POST'])]
    public function delete(Request $request, SB $sB, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sB->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sB);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_monsters_s_b_index', [], Response::HTTP_SEE_OTHER);
    }
}
