<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/alldrivers', name: 'app_all_drivers')]
    public function getCollection(EntityManagerInterface $entityManager): Response
    {
        $personRepository = $entityManager->getRepository(Person::class);
        $people = $personRepository->findAll();

        return $this->render('data/drivers.html.twig', [
            'people' => $people,
        ]);
    }
}
