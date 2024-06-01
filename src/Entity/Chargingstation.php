<?php

namespace App\Entity;

use App\Repository\ChargingstationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


#[ORM\Entity(repositoryClass: ChargingstationRepository::class)]
class Chargingstation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $id;

    #[ORM\Column]
    private ?bool $inUse = false;

    /**
     * @var Collection<int, Connector>
     */
    #[ORM\OneToMany(targetEntity:Connector::class, mappedBy:"chargingstation", cascade: ['persist', 'remove'])]
    private Collection $connectors;

    public function __construct()
    {
        $this->connectors = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
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

    /**
     * @var Collection<int, Connector>
     */
    public function getConnectors(): Collection
    {
        return $this->connectors;
    }

    public function addConnectors(Connector $connectors): static
    {
        if (!$this->connectors->contains($connectors)) {
                $this->connectors->add($connectors);
                $connectors->addChargingStation($this);
        }

        return $this;
    }
    
    public function removeConnectors(Connector $connectors): static
    {
        if ($this->connectors->removeElement($connectors)) {
            // Set the owning side to null (unless already changed)
            if ($connectors->getChargingStation() === $this) {
                $connectors->removeChargingStation($this);
            }
        }

        return $this;
    }
}
