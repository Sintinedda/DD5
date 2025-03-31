<?php

namespace App\Controller\Classes;

use App\Entity\Classes\Classe;
use App\Entity\Classes\ClasseLevel;
use App\Entity\Classes\ClasseSpellcasting;
use App\Entity\Construct\Skill;
use App\Form\Construct\SkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/classe-skill')]
final class ClasseSkillController extends AbstractController
{
    #[Route('/classe{id}/new', name: 'classe_skill_level_new', methods: ['GET', 'POST'])]
    public function newLevels(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]);
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lvls = $form->get('lvls')->getData();
            foreach ($lvls as $lvl) {
                $level = $entityManager->getRepository(ClasseLevel::class)->findOneBy(['classe' => $classe, 'level' => $lvl]);
                $skill->addClasseLevel($level);
            }
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_skill/new.html.twig', [
            'classe_skill' => $skill,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/spellcast{id}/new', name: 'classe_skill_spellcasting_new', methods: ['GET', 'POST'])]
    public function newSpellcasting(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $spellcasting = $entityManager->getRepository(ClasseSpellcasting::class)->findOneBy(['id' => $id]);
        $classe = $spellcasting->getClasse();
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->setSpellcasting($spellcasting);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $classe->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/classe_skill/newspell.html.twig', [
            'classe_skill' => $skill,
            'form' => $form,
            'id' => $classe->getId()
        ]);
    }

    #[Route('/classe{id}/{id2}/edit', name: 'classe_skill_edit', methods: ['GET', 'POST'])]
    public function editLevels(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]); 
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]); 
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($skill->getClasseLevels()->count() != 0) {
                $dels = $entityManager->getRepository(ClasseLevel::class)->findBy(['classe' => $classe]);
                foreach ($dels as $del) {
                    $skill->removeClasseLevel($del);
                }
                $lvls = $form->get('lvls')->getData();
                foreach ($lvls as $lvl) {
                    $level = $entityManager->getRepository(ClasseLevel::class)->findOneBy(['classe' => $classe, 'level' => $lvl]);
                    $skill->addClasseLevel($level);
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        if ($skill->getSpellcasting() != NULL) {
            
            return $this->render('classes/classe_skill/editspell.html.twig', [
                'classe_skill' => $skill,
                'form' => $form,
                'id' => $id
            ]);
        } else {

            return $this->render('classes/classe_skill/edit.html.twig', [
                'classe_skill' => $skill,
                'form' => $form,
                'id' => $id
            ]);
        }
    }

    #[Route('/classe{id}/{id2}', name: 'classe_skill_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->findOneBy(['id' => $id]); 
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->getPayload()->getString('_token'))) {
            if ($skill->getClasseLevels()->count() != 0) {
                $dels = $entityManager->getRepository(ClasseLevel::class)->findBy(['classe' => $classe]);
                foreach ($dels as $del) {
                    $skill->removeClasseLevel($del);
                }
                if ($skill->getClasseLevels()->count() == 0) {
                    $entityManager->remove($skill);
                }
            } else {
                $entityManager->remove($skill);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
