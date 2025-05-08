<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vol;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $id = $request->query->get('id');
        $prix = $request->query->get('prix');
        $vol = $entityManager->getRepository(Vol::class)->find($id);
        $reservation = new Reservation();
        $reservation->setPrixBillet((float)$prix);
        $reservation->setRefUtilisateur($this->getUser());
        $reservation->setRefVol($vol);
        $entityManager->persist($reservation);
        $entityManager->flush();


        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/destination', name: 'app_reservation_destination', methods: ['GET'])]
    public function destination(VolRepository $volRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $destination = $volRepository->getAllVols($entityManager);
        return $this->render('reservation/allReservation.html.twig', [
            'destinations' => $destination,
        ]);
    }
    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $entityManager->remove($reservation);
        $entityManager->flush();
        

        return $this->redirectToRoute('app_utilisateur_profil', [], Response::HTTP_SEE_OTHER);
    }
}
