<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseListe;
use App\Entity\Classes\ClasseSkill;
use App\Form\Classes\ClasseListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-liste')]
final class ClasseListeController extends AbstractController
{
    #[Route('/classe{id}/skill{id2}/new', name: 'classe_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(ClasseSkill::class)->findOneBy(['id' => $id2]);
        $classeListe = new ClasseListe();
        $form = $this->createForm(ClasseListeType::class, $classeListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeListe->setSkill($skill);
            $entityManager->persist($classeListe);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_liste/new.html.twig', [
            'classe_liste' => $classeListe,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeListe = $entityManager->getRepository(ClasseListe::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ClasseListeType::class, $classeListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_liste/edit.html.twig', [
            'classe_liste' => $classeListe,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/classe{id}/{id2}', name: 'classe_liste_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classeListe = $entityManager->getRepository(ClasseListe::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$classeListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
