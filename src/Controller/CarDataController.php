<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarDataController extends AbstractController
{
    #[Route('/allcars', name: 'app_all_cars')]
    public function getCollection(EntityManagerInterface $entityManager): Response
    {
        $carsRepository = $entityManager->getRepository(Car::class);
        $cars = $carsRepository->findAll();

        return $this->render('data/cars.html.twig', [
            'cars' => $cars,
        ]);
    }
}
