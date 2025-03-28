<?php

namespace App\Controller\Races;

use App\Entity\Construct\Liste;
use App\Entity\Construct\Skill;
use App\Form\Construct\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/race-liste')]
final class RaceListeController extends AbstractController
{
    #[Route('/srace{id}/skill{id2}/new', name: 'srace_liste_new', methods: ['GET', 'POST'])]
    public function newSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->setSkill($skill);
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_liste/new/srace.html.twig', [
            'liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/skill{id2}/new', name: 'ssrace_liste_new', methods: ['GET', 'POST'])]
    public function newSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->setSkill($skill);
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_liste/new/ssrace.html.twig', [
            'liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}/edit', name: 'srace_liste_edit', methods: ['GET', 'POST'])]
    public function editSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $liste = $entityManager->getRepository(Liste::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_liste/edit/srace.html.twig', [
            'liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/{id2}/edit', name: 'ssrace_liste_edit', methods: ['GET', 'POST'])]
    public function editSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $liste = $entityManager->getRepository(Liste::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_liste/edit/ssrace.html.twig', [
            'liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}', name: 'srace_liste_delete', methods: ['POST'])]
    public function deleteSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $liste = $entityManager->getRepository(Liste::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ssrace{id}/{id2}', name: 'ssrace_liste_delete', methods: ['POST'])]
    public function deleteSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $liste = $entityManager->getRepository(Liste::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
