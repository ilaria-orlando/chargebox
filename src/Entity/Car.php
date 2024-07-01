<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'car_sequence', allocationSize: 5, initialValue: 1)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $batteryCapacity = 80;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'assignedCars')]
    private Collection $assignedTo;

    public function __construct()
    {
        $this->assignedTo = new ArrayCollection();
    }

    public function getId(): ?int
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
