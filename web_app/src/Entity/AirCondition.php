<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AirConditionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirConditionRepository::class)]
#[ApiResource]
class AirCondition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\Column]
    private ?float $humidity = null;

    #[ORM\Column]
    private ?float $atmospheric_pressure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getAtmosphericPressure(): ?float
    {
        return $this->atmospheric_pressure;
    }

    public function setAtmosphericPressure(float $atmospheric_pressure): self
    {
        $this->atmospheric_pressure = $atmospheric_pressure;

        return $this;
    }
}
