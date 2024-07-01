<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Chargingstation;
use App\Entity\Connector;
use App\Factory\PersonFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 14 cars, create 1 random person, relate them
        for ($i = 1; $i <= 14; ++$i) {
            $car = new Car();
            $car->setBatteryCapacity('80');

            $person = PersonFactory::createOne();
            $actualPerson = $person->object();

            $actualPerson->addAssignedCars($car);

            $manager->persist($car);
            $manager->persist($actualPerson);
        }

        // create 5 chargingstations, create 2 connectors for each, relate them
        for ($i = 1; $i <= 5; ++$i) {
            $station = new Chargingstation();
            $station->setName('Station'.$i);

            $connector1 = new Connector();
            $connector1->setName('Station'.$i.'Connector 1');

            $connector2 = new Connector();
            $connector2->setName('Station'.$i.'Connector 2');

            $station->addConnector($connector1);
            $station->addConnector($connector2);

            $manager->persist($station);
        }

        $manager->flush();

        // add 15th car to 14th person
        $extraCar = new Car();
        $manager->persist($extraCar);

        $lastPerson = PersonFactory::last()->object();
        $lastPerson->addAssignedCars($extraCar);

        $manager->persist($lastPerson);

        $manager->flush();
    }
}
