<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{

    #[Route('/reservations')]
    public function getCollection(EntityManagerInterface $entitymanager): Response
    {
        $reservationRepository = $entitymanager->getRepository(Reservation::class);
        $reservations = $reservationRepository->findAll();

        return $this->render('data/reservations.html.twig', [
            'reservations' => $reservations
        ]);
    }

}
