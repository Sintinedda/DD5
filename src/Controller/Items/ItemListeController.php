<?php

namespace App\Controller\Items;

use App\Entity\Construct\Liste;
use App\Entity\Construct\Skill;
use App\Entity\Items\ItemSubcategory;
use App\Form\Construct\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/item-liste')]
final class ItemListeController extends AbstractController
{
    #[Route('/new/cat={id}/skill={id2}', name: 'item_liste_skill_cat_new', methods: ['GET', 'POST'])]
    public function newSkillCategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill =$entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->setSkill($skill);
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/new/cat.html.twig', [
            'item_liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}/skill={id2}', name: 'item_liste_skill_sub_new', methods: ['GET', 'POST'])]
    public function newSkillSubcategory(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill =$entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->setSkill($skill);
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/new/sub.html.twig', [
            'item_liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/new/sub={id}', name: 'item_liste_sub_new', methods: ['GET', 'POST'])]
    public function newSubcategory(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $sub =$entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id]);
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste->addItemSubcategory($sub);
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/new/sub.html.twig', [
            'item_liste' => $liste,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit/cat={id2}/skill', name: 'item_liste_skill_cat_edit', methods: ['GET', 'POST'])]
    public function editSkillCategory(Request $request, Liste $liste, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/edit/cat.html.twig', [
            'item_liste' => $liste,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/edit/sub={id2}', name: 'item_liste_sub_edit', methods: ['GET', 'POST'])]
    public function editSubcategory(Request $request, Liste $liste, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($liste->getItemSubcategories()->count() != 0) {
                $liste->addItemSubcategory($sub); 
            }
            $entityManager->flush();

            return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items/item_liste/edit/sub.html.twig', [
            'item_liste' => $liste,
            'form' => $form,
            'id' => $id2
        ]);
    }

    #[Route('/{id}/cat={id2}/skill', name: 'item_liste_skill_cat_delete', methods: ['POST'])]
    public function deleteSkillCategory(Request $request, Liste $liste, EntityManagerInterface $entityManager, int $id2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('items_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/sub={id2}', name: 'item_liste_sub_delete', methods: ['POST'])]
    public function deleteSubcategory(Request $request, Liste $liste, EntityManagerInterface $entityManager, int $id2): Response
    {
        $sub = $entityManager->getRepository(ItemSubcategory::class)->findOneBy([ 'id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->getPayload()->getString('_token'))) {
            if ($liste->getItemSubcategories()->count() != 0) {
                $liste->removeItemSubcategory($sub);
                if ($liste->getItemSubcategories()->count() == 0) {
                    $entityManager->remove($liste);
                }
            } else {
                $entityManager->remove($liste);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_sub_show', ['id' => $id2], Response::HTTP_SEE_OTHER);
    }
}
