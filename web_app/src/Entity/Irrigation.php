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

    #[ORM\Column]
    private ?int $plant_id = 0;

    #[ORM\Column]
    private ?int $area_id = 0;

    #[ORM\Column]
    private ?int $air_condition_id = 0;

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

    public function getPlantId(): ?int
    {
        return $this->plant_id;
    }

    public function setPlantId(?int $plant_id): self
    {
        $this->plant_id = $plant_id;

        return $this;
    }

    public function getAreaId(): ?int
    {
        return $this->area_id;
    }

    public function setAreaId(?int $area_id): self
    {
        $this->area_id = $area_id;

        return $this;
    }

    public function getAirConditionId(): ?int
    {
        return $this->air_condition_id;
    }

    public function setAirConditionId(int $air_condition_id): self
    {
        $this->air_condition_id = $air_condition_id;

        return $this;
    }
}
