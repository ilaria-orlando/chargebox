<?php

namespace App\Controller;

use App\Entity\Chargingstation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChargingstationController extends AbstractController
{
    #[Route('/allchargingstations', name: 'app_all_chargingstations')]
    public function getCollection(EntityManagerInterface $entityManager): Response
    {
        $stationRepository = $entityManager->getRepository(Chargingstation::class);
        $stations = $stationRepository->findAll();

        return $this->render('data/chargingstations.html.twig', [
            'stations' => $stations,
        ]);
    }
}
