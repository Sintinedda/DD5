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

#[Route('/admin/monster')]
final class SBController extends AbstractController
{
    #[Route(name: 'monster', methods: ['GET'])]
    public function index(SBRepository $sBRepository): Response
    {
        return $this->render('monsters/sb/index.html.twig', [
            'sbs' => $sBRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'monster_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sB = new SB();
        $form = $this->createForm(SBType::class, $sB);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sB);
            $entityManager->flush();

            return $this->redirectToRoute('monster_show', ['id' => $sB->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb/new.html.twig', [
            'sb' => $sB,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'monster_show', methods: ['GET'])]
    public function show(SB $sB): Response
    {
        return $this->render('monsters/sb/show.html.twig', [
            'sb' => $sB,
        ]);
    }

    #[Route('/{id}/edit', name: 'monster_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SB $sB, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SBType::class, $sB);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('monster_show', ['id' => $sB->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monsters/sb/edit.html.twig', [
            'sb' => $sB,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'monster_delete', methods: ['POST'])]
    public function delete(Request $request, SB $sB, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sB->getId(), $request->getPayload()->getString('_token'))) {
            $sB->setSpecialty(NULL);
            $entityManager->remove($sB);
            $entityManager->flush();
        }

        return $this->redirectToRoute('monster', [], Response::HTTP_SEE_OTHER);
    }
}
