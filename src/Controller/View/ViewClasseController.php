<?php

namespace App\Controller\View;

use App\Entity\Classes\Classe;
use App\Entity\Classes\SpecialtyItem;
use App\Repository\Classes\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classe')]
final class ViewClasseController extends AbstractController
{
    #[Route(name: 'view_classes', methods: ['GET'])]
    public function index(ClasseRepository $classeRepository): Response
    {
        return $this->render('view/classe/index.html.twig', [
            'classes' => $classeRepository->findAll(),
        ]);
    }

    #[Route('/{slug}', name: 'view_classe', methods: ['GET'])]
    public function show(string $slug, EntityManagerInterface $em): Response
    {
        $classe = $em->getRepository(Classe::class)->findOneBy(['slug' => $slug]);

        return $this->render('view/classe/show.html.twig', [
            'classe' => $classe,
        ]);
    }

    #[Route('/{slug}/spe={slug2}', name: 'view_specialty', methods: ['GET'])]
    public function showSpecialty(string $slug, string $slug2, EntityManagerInterface $em): Response
    {
        $classe = $em->getRepository(Classe::class)->findOneBy(['slug' => $slug]);
        $specialty = $em->getRepository(SpecialtyItem::class)->findOneBy(['slug' => $slug2]);

        return $this->render('view/specialty/show.html.twig', [
            'classe' => $classe,
            'specialty' => $specialty
        ]);
    }
}
