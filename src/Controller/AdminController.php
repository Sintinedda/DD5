<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route(name: 'admin', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('bo/index.html.twig');
    }
}