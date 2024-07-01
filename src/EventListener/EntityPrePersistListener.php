<?php

namespace App\EventListener;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs as EventLifecycleEventArgs;

class EntityPrePersistListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function prePersist(EventLifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Car) {
            $this->handleCarPrePersist($entity);
        }
    }

    //TODO car_model_sequence does not transfer when creating database backup
    // set prepersist for car, auto increment model number
    public function handleCarPrePersist(Car $car): void
    {
        if (null === $car->getModel()) {
            $connect = $this->entityManager->getConnection();
            $query = $connect->executeQuery('SELECT nextval(\'car_model_seq\')');
            $seqValue = $query->fetchOne();

            if (false !== $seqValue) {
                $car->setModel('TES'.$seqValue);
            } else {
                $car->setModel('Unknown');
            }
        }
    }
}
