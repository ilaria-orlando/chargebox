<?php

namespace App\Entity;

use App\Repository\ChargingstationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChargingstationRepository::class)]
class Chargingstation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'chargingstation_sequence', allocationSize: 5, initialValue: 1)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $inUse = false;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Connector::class, mappedBy: 'chargingstation', cascade: ['persist', 'remove'])]
    private Collection $connectors;

    public function __construct()
    {
        $this->connectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getConnectors(): Collection
    {
        return $this->connectors;
    }

    public function addConnector(Connector $connector): static
    {
        if (!$this->connectors->contains($connector)) {
            $this->connectors->add($connector);
            $connector->setChargingstation($this);
        }

        return $this;
    }

    public function removeConnector(Connector $connector): static
    {
        if ($this->connectors->removeElement($connector)) {
            // Set the owning side to null (unless already changed)
            if ($connector->getChargingstation() === $this) {
                $connector->setChargingstation(null);
            }
        }

        return $this;
    }
}
