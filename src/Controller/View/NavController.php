<?php

namespace App\Controller\View;

use App\Entity\Assets\School;
use App\Entity\Classes\Classe;
use App\Entity\Items\ItemCategory;
use App\Entity\Races\Race;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class NavController extends AbstractController
{
    public function nav(
        $route,
        EntityManagerInterface $em
    ): Response
    {
        return $this->render('view/nav/_nav.html.twig', [
            'user' => $this->getUser(),
            'route' => $route,
            'itemCategories' => $em->getRepository(ItemCategory::class)->findAll(),
            'schools' => $em->getRepository(School::class)->findAll(),
            'classes' => $em->getRepository(Classe::class)->findAll(),
            'commons' => $em->getRepository(Race::class)->findBy(['type' => 'Commune']),
            'exotics' => $em->getRepository(Race::class)->findBy(['type' => 'Exotique']),
            'monstruous' => $em->getRepository(Race::class)->findBy(['type' => 'Monstrueuse']),
        ]);
    }
}