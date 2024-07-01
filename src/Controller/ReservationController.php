<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\Type\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservations')]
class ReservationController extends AbstractController
{
    #[Route('/new', name: 'app_reservation_new')]
    public function getCollection(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $allReservations = $reservationRepository->findAll();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // set end time to be +2 hours from starttime
            $startTime = $reservation->getStartTime();
            if ($startTime) {
                $endTime = (clone $startTime)->modify('+2 hours');
                $reservation->setEndTime($endTime);
            }

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_success');
        }

        return $this->render('data/reservations.html.twig', [
            'reservations' => $allReservations,
            'form' => $form,
        ]);
    }

    // TODO inject reservation objects into calendar
    // render calendar
    #[Route(path: '/calendar', name: 'app_reservation_calendar')]
    public function calendar(): Response
    {
        return $this->render('reservations/calendar.html.twig');
    }

    #[Route('/reservation/success', name: 'reservation_success')]
    public function success(): Response
    {
        return new Response('<html><body>Reservation successfully created!</body></html>');
    }
}
