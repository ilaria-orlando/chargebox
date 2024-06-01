<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $id;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $batteryCapacity = null;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\ManyToMany(targetEntity:Person::class, inversedBy:"assignedCars")]
    private Collection $assignedTo;

    public function __construct()
    {
        $this->assignedTo = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getBatteryCapacity(): ?int
    {
        return $this->batteryCapacity;
    }

    public function setBatteryCapacity(int $batteryCapacity): static
    {
        $this->batteryCapacity = $batteryCapacity;

        return $this;
    }


    /**
     * @var Collection<int, Person>
     */
    public function getAssignedTo(): Collection
    {
        return $this->assignedTo;
    }


    public function addAssignedTo(Person $person): static
    {
            if (!$this->assignedTo->contains($person)) {
                $this->assignedTo->add($person);
                $person->addAssignedCars($this);
        }

        return $this;
    }

    public function removeAssignedTo(Person $person): self
    {
        if ($this->assignedTo->removeElement($person)) {
            if ($person->getAssignedCars() === $this) {
                $person->removeAssignedCars($this);
            }
        }

        return $this;
    }
}