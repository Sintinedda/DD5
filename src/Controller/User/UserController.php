<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users')]
final class UserController extends AbstractController
{
    #[Route(name: 'users', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('bo/user/index.html.twig',[
            'users' => $em->getRepository(User::class)->findAll(),
        ]);
    }

    #[Route('/edit-role/{id}', name: 'user_edit_role', methods: ['POST'])]
    public function editRole(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('role'.$user->getId(), $request->getPayload()->getString('_token'))) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                $user->setRoles([]);
            } else {
                $user->setRoles(['ROLE_ADMIN']);
            }
            $em->flush();
        }

        return $this->redirectToRoute('users', [], Response::HTTP_SEE_OTHER);
    }
}