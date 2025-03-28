<?php

namespace App\Controller\Races;

use App\Entity\Construct\Skill;
use App\Entity\Construct\Table;
use App\Entity\Races\RaceSource;
use App\Entity\Races\RaceSubrace;
use App\Form\Construct\TableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/race-table')]
final class RaceTableController extends AbstractController
{
    #[Route('srace{id}/new', name: 'srace_table_new', methods: ['GET', 'POST'])]
    public function newSrace(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $race = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->addRaceSource($race);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/new/srace.html.twig', [
            'table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('ssrace{id}/new', name: 'ssrace_table_new', methods: ['GET', 'POST'])]
    public function newSsrace(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $race = $entityManager->getRepository(RaceSubrace::class)->findOneBy(['id' => $id]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->addRaceSubrace($race);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/new/ssrace.html.twig', [
            'table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('srace{id}/skill{id2}/new', name: 'srace_table_skill_new', methods: ['GET', 'POST'])]
    public function newSraceSkill(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->setSkill($skill);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/new/srace.html.twig', [
            'table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('ssrace{id}/skill{id2}/new', name: 'ssrace_table_skill_new', methods: ['GET', 'POST'])]
    public function newSsraceSkill(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id' => $id2]);
        $table = new Table();
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table->setSkill($skill);
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/new/ssrace.html.twig', [
            'table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}/edit', name: 'srace_table_edit', methods: ['GET', 'POST'])]
    public function editSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($table->getRaceSources()->count() != 0) {
                $table->addRaceSource($race);
            }
            $entityManager->flush();

            return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/edit/srace.html.twig', [
            'table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/ssrace{id}/{id2}/edit', name: 'ssrace_table_edit', methods: ['GET', 'POST'])]
    public function editSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSubrace::class)->findOneBy(['id' => $id]);
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);
        $form = $this->createForm(TableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($table->getRaceSubraces()->count() != 0) {
                $table->addRaceSubrace($race);
            }
            $entityManager->flush();

            return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/race_table/edit/ssrace.html.twig', [
            'table' => $table,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/srace{id}/{id2}', name: 'srace_table_delete', methods: ['POST'])]
    public function deleteSrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSource::class)->findOneBy(['id' => $id]);
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->getPayload()->getString('_token'))) {
            if ($table->getRaceSources()->count() != 0) {
                $table->removeRaceSource($race);
                if ($table->getRaceSources()->count() == 0) {
                    $entityManager->remove($table);
                }
            } else {
                $entityManager->remove($table);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('srace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ssrace{id}/{id2}', name: 'ssrace_table_delete', methods: ['POST'])]
    public function deleteSsrace(Request $request, EntityManagerInterface $entityManager, int $id, int $id2): Response
    {
        $race = $entityManager->getRepository(RaceSubrace::class)->findOneBy(['id' => $id]);
        $table = $entityManager->getRepository(Table::class)->findOneBy(['id' => $id2]);

        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->getPayload()->getString('_token'))) {
            if ($table->getRaceSubraces()->count() != 0) {
                $table->removeRaceSubrace($race);
                if ($table->getRaceSubraces()->count() == 0) {
                    $entityManager->remove($table);
                }
            } else {
                $entityManager->remove($table);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssrace_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
