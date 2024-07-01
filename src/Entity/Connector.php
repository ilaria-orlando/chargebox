<?php

namespace App\Entity;

use App\Repository\ConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectorRepository::class)]
class Connector
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'connector_sequence', allocationSize: 5, initialValue: 1)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Chargingstation::class, inversedBy: 'connectors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chargingstation $chargingstation = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'connector', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    #[ORM\Column(nullable: true)]
    private ?int $wattage = null;

    #[ORM\Column]
    private ?bool $inUse = false;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getChargingstation(): ?Chargingstation
    {
        return $this->chargingstation;
    }

    public function setChargingstation(?Chargingstation $chargingstation): static
    {
        $this->chargingstation = $chargingstation;

        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setConnector($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // Set the owning side to null (unless already changed)
            if ($reservation->getConnector() === $this) {
                $reservation->setConnector(null);
            }
        }

        return $this;
    }

    public function getWattage(): ?int
    {
        return $this->wattage;
    }

    public function setWattage(?int $wattage): static
    {
        $this->wattage = $wattage;

        return $this;
    }

    public function isInUse(): ?bool
    {
        return $this->inUse;
    }

    public function setInUse(bool $inUse): static
    {
        $this->inUse = $inUse;

        return $this;
    }
}
