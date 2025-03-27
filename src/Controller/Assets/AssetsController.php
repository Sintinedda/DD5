<?php

namespace App\Controller\Assets;

use App\Entity\Assets\Alignment;
use App\Entity\Assets\Competence;
use App\Entity\Assets\Condition;
use App\Entity\Assets\CreatureType;
use App\Entity\Assets\Damage;
use App\Entity\Assets\Language;
use App\Entity\Assets\School;
use App\Entity\Assets\Sense;
use App\Entity\Assets\Speed;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/assets')]
final class AssetsController extends AbstractController
{
    #[Route(name: 'assets', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('assets/index.html.twig', [
            'alignments' => $em->getRepository(Alignment::class)->findAll(),
            'competences' => $em->getRepository(Competence::class)->findAll(),
            'conditions' => $em->getRepository(Condition::class)->findAll(),
            'creatureTypes' => $em->getRepository(CreatureType::class)->findAll(),
            'damages' => $em->getRepository(Damage::class)->findAll(),
            'languages' => $em->getRepository(Language::class)->findAll(),
            'schools' => $em->getRepository(School::class)->findAll(),
            'senses' => $em->getRepository(Sense::class)->findAll(),
            'speeds' => $em->getRepository(Speed::class)->findAll(),
        ]);
    }
}