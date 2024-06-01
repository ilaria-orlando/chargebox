<?php

namespace App\Factory;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Person>
 *
 * @method        Person|Proxy                     create(array|callable $attributes = [])
 * @method static Person|Proxy                     createOne(array $attributes = [])
 * @method static Person|Proxy                     find(object|array|mixed $criteria)
 * @method static Person|Proxy                     findOrCreate(array $attributes)
 * @method static Person|Proxy                     first(string $sortedField = 'id')
 * @method static Person|Proxy                     last(string $sortedField = 'id')
 * @method static Person|Proxy                     random(array $attributes = [])
 * @method static Person|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PersonRepository|RepositoryProxy repository()
 * @method static Person[]|Proxy[]                 all()
 * @method static Person[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Person[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Person[]|Proxy[]                 findBy(array $attributes)
 * @method static Person[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Person[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PersonFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Person $person): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Person::class;
    }

   /**protected function instantiate(array $attributes): object
    {
        $id = Uuid::uuid4(); // Generate UUID
        return new Person($id, $attributes['name']);
    }

    //link car to person
    /**public static function createPersonCarPermissions(int $count): void
    {
        //get all cars
        $cars = CarFactory::repository()->findAll();

        for ($i = 1; $i <= $count; $i++) {
            $person = self::createOne();

            foreach($cars as $car) {

                if($car->getAssignedTo()->getId() === $person->getId()) {
                    $person->setCarPermission($car);
                    break;
                }
            }

            $person->save();

        }
    }*/
}
