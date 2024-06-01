<?php

namespace App\Entity;

use App\Repository\ConnectorRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;


#[ORM\Entity(repositoryClass: ConnectorRepository::class)]
class Connector
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $id;

    #[ORM\ManyToOne(targetEntity:Chargingstation::class, inversedBy:"connectors")]
    #[ORM\JoinColumn]
    private ?Chargingstation $chargingstation;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'connectorId', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $reservation;

    #[ORM\Column(nullable: true)]
    private ?int $wattage = null;

    #[ORM\Column]
    private ?bool $inUse = false;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getChargingstation(): Chargingstation
    {
        return $this->chargingstation;
    }

    public function addChargingstation(Chargingstation $chargingstation): static
    {
        $this->chargingstation = $chargingstation;
        return $this;
    }

    public function removeChargingstation(): static
    {
        $this->chargingstation = null;
        return $this;
    }

    /**
     * @var Collection<int, Reservation>
     */
    public function getreservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
                $this->reservation->add($reservation);
                $reservation->addConnectorId($this);
        }

        return $this;
    }
    
    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // Set the owning side to null (unless already changed)
            if ($reservation->getConnectorId() === $this) {
                $reservation->removeConnectorId($this);
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

    public function isStatus(): ?bool
    {
        return $this->inUse;
    }

    public function setStatus(bool $inUse): static
    {
        $this->inUse = $inUse;

        return $this;
    }
}
