<?php

namespace App\Controller\Classes;

use App\Entity\Classes\ClasseListe;
use App\Form\Classes\ClasseListeType;
use App\Repository\Classes\ClasseListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classes/classe/liste')]
final class ClasseListeController extends AbstractController
{
    #[Route(name: 'app_classes_classe_liste_index', methods: ['GET'])]
    public function index(ClasseListeRepository $classeListeRepository): Response
    {
        return $this->render('classes/classe_liste/index.html.twig', [
            'classe_listes' => $classeListeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_classe_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeListe = new ClasseListe();
        $form = $this->createForm(ClasseListeType::class, $classeListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeListe);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_liste/new.html.twig', [
            'classe_liste' => $classeListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_liste_show', methods: ['GET'])]
    public function show(ClasseListe $classeListe): Response
    {
        return $this->render('classes/classe_liste/show.html.twig', [
            'classe_liste' => $classeListe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classes_classe_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseListe $classeListe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseListeType::class, $classeListe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_classe_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_liste/edit.html.twig', [
            'classe_liste' => $classeListe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_classe_liste_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseListe $classeListe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeListe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeListe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_classe_liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
