<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'personId', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $reservation;

    //link collection to other entity
    /**
     * @var Collection<int, Car>
     */
    #[ORM\ManyToMany(mappedBy: 'assignedTo', targetEntity: Car::class, cascade: ['persist', 'remove'])]
    private Collection $assignedCars;

    //construct an array of said collection
    public function __construct()
    {
        $this->reservation = new ArrayCollection();
        $this->assignedCars = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getAssignedCars(): Collection
    {
        return $this->assignedCars;
    }

    public function addAssignedCars(Car $assignedCars): static
    {
            if (!$this->assignedCars->contains($assignedCars)) {
                $this->assignedCars->add($assignedCars);
                $assignedCars->addAssignedTo($this);

        }

        return $this;
    }

    public function removeAssignedCars(Car $assignedCars): static
    {
        if ($this->assignedCars->removeElement($assignedCars)) {
            if ($assignedCars->getAssignedTo() === $this) {
                $assignedCars->removeAssignedTo($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection<string, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->addPersonId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getPersonId() === $this) {
                $reservation->removePersonId($this);
            }
        }

        return $this;
    }

}