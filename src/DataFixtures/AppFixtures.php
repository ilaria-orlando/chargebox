<?php

namespace App\DataFixtures;

use App\Factory\CarFactory;
use App\Factory\PersonFactory;
use App\Entity\Person;
use App\Entity\Car;
use App\Entity\Chargingstation;
use App\Entity\Connector;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void

    {
        
        PersonFactory::createMany(14);
        CarFactory::createSpecificModels(14);

        $chargingStation = new Chargingstation();

        $connector1 = new Connector();
        $connector2 = new Connector();

        $chargingStation->addConnectors($connector1);
        $chargingStation->addConnectors($connector2);

        $manager->persist($chargingStation);
        
        $manager->flush();

        $cars = $manager->getRepository(Car::class)->findAll();
        $people = $manager->getRepository(Person::class)->findAll();

        foreach($people as $person){
            $person->addAssignedCars($cars[array_rand($cars)]);

            $manager->persist($person);
        }

        $person = $people[array_rand($people)];
        $reservation =  new Reservation();
        $reservation->addConnectorId($connector2);
        $reservation->addPersonId($person);

        $manager->persist($reservation);

        $manager->flush();
    }

}

        /**$persons = PersonFactory::createMany(14, function() use ($cars) {
            return[
                'carPermission' => $cars[array_rand($cars)],
            ];
        });

        foreach ($cars as $car) {
            if ($car->getAssignedTo() === null) {
                $randomPerson = $persons[array_rand($persons)];
                $car->setAssignedTo($randomPerson);
            }
        }
        
        foreach($persons as $person) {

            foreach($cars as $car) {

                if($car->getAssignedTo() === $person->getId()) {
                    $person->setCarPermission($car);
                    break;
                }
            }

            $manager->persist($person);

        }
        
        foreach($cars as $car) {

            foreach($persons as $person) {

                if($car->getAssignedTo()->getId() === $person->getId()) {
                    $person->setCarPermission($car);
                    break;
                }

                $manager->persist($person);
            }

            
        }

        PersonFactory::createMany(14);
        CarFactory::createSpecificModels(14);
        
        $manager->flush();

        $cars = $manager->getRepository(Car::class)->findAll();
        $people = $manager->getRepository(Person::class)->findAll();

        foreach($people as $person){
            $person->addAssignedCars($cars[array_rand($cars)]);

            $manager->persist($person);
        }

        $manager->flush();
    }

        $car = new Car();
        $car->setModel('TES1');
        $car->setBatteryCapacity('80');
        
        $person = new Person();
        $person->setName('Ilaria Orlando');

        $person->addAssignedCars($car);
        
        $manager->persist($car);
        $manager->persist($person);
        $manager->flush();

        $car2 = new Car();
        $car2->setModel('TES2');
        $car2->setBatteryCapacity('80');

        $person->addAssignedCars($car2);

        $manager->persist($car2);
        $manager->persist($person);

        $manager->flush();

    }

*/
