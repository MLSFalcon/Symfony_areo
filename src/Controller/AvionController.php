<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Form\AvionType;
use App\Repository\AvionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avion')]
class AvionController extends AbstractController
{
    #[Route('/', name: 'app_avion_index', methods: ['GET'])]
    public function index(AvionRepository $avionRepository): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('avion/index.html.twig', [
            'avions' => $avionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        $avion = new Avion();
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avion);
            $entityManager->flush();

            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avion/new.html.twig', [
            'avion' => $avion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avion_show', methods: ['GET'])]
    public function show(Avion $avion): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('avion/show.html.twig', [
            'avion' => $avion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avion $avion, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avion/edit.html.twig', [
            'avion' => $avion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avion_delete', methods: ['POST'])]
    public function delete(Request $request, Avion $avion, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$avion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
    }
}
