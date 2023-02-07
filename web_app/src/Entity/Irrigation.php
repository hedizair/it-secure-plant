<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IrrigationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IrrigationRepository::class)]
#[ApiResource]
class Irrigation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $watering_start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $watering_end_date = null;

    #[ORM\Column(nullable: true)]
    private ?float $duration = null;

    #[ORM\ManyToOne]
    private ?Plant $plant = null;

    #[ORM\ManyToOne]
    private ?Area $area = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?AirCondition $air_condition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWateringStartDate(): ?\DateTimeInterface
    {
        return $this->watering_start_date;
    }

    public function setWateringStartDate(\DateTimeInterface $watering_start_date): self
    {
        $this->watering_start_date = $watering_start_date;

        return $this;
    }

    public function getWateringEndDate(): ?\DateTimeInterface
    {
        return $this->watering_end_date;
    }

    public function setWateringEndDate(?\DateTimeInterface $watering_end_date): self
    {
        $this->watering_end_date = $watering_end_date;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPlant(): ?Plant
    {
        return $this->plant;
    }

    public function setPlant(?Plant $plant): self
    {
        $this->plant = $plant;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getAirCondition(): ?AirCondition
    {
        return $this->air_condition;
    }

    public function setAirCondition(AirCondition $air_condition): self
    {
        $this->air_condition = $air_condition;

        return $this;
    }
}
