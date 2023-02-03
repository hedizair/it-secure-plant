<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantRepository::class)]
#[ApiResource]
class Plant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $scientific_name = null;

    #[ORM\Column(length: 255)]
    private ?string $flowering_period = null;

    #[ORM\Column(length: 255)]
    private ?string $flower_color = null;

    #[ORM\Column(length: 255)]
    private ?string $foliage = null;

    #[ORM\Column(length: 255)]
    private ?string $hardiness = null;

    #[ORM\Column(length: 255)]
    private ?string $exposure = null;

    #[ORM\Column(length: 255)]
    private ?string $ground_information = null;

    #[ORM\Column(length: 255)]
    private ?string $humidity = null;

    #[ORM\Column(length: 255)]
    private ?string $planting_period = null;

    #[ORM\Column(length: 255)]
    private ?string $multiplication_method = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getScientificName(): ?string
    {
        return $this->scientific_name;
    }

    public function setScientificName(string $scientific_name): self
    {
        $this->scientific_name = $scientific_name;

        return $this;
    }

    public function getFloweringPeriod(): ?string
    {
        return $this->flowering_period;
    }

    public function setFloweringPeriod(string $flowering_period): self
    {
        $this->flowering_period = $flowering_period;

        return $this;
    }

    public function getFlowerColor(): ?string
    {
        return $this->flower_color;
    }

    public function setFlowerColor(string $flower_color): self
    {
        $this->flower_color = $flower_color;

        return $this;
    }

    public function getFoliage(): ?string
    {
        return $this->foliage;
    }

    public function setFoliage(string $foliage): self
    {
        $this->foliage = $foliage;

        return $this;
    }

    public function getHardiness(): ?string
    {
        return $this->hardiness;
    }

    public function setHardiness(string $hardiness): self
    {
        $this->hardiness = $hardiness;

        return $this;
    }

    public function getExposure(): ?string
    {
        return $this->exposure;
    }

    public function setExposure(string $exposure): self
    {
        $this->exposure = $exposure;

        return $this;
    }

    public function getGroundInformation(): ?string
    {
        return $this->ground_information;
    }

    public function setGroundInformation(string $ground_information): self
    {
        $this->ground_information = $ground_information;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getPlantingPeriod(): ?string
    {
        return $this->planting_period;
    }

    public function setPlantingPeriod(string $planting_period): self
    {
        $this->planting_period = $planting_period;

        return $this;
    }

    public function getMultiplicationMethod(): ?string
    {
        return $this->multiplication_method;
    }

    public function setMultiplicationMethod(string $multiplication_method): self
    {
        $this->multiplication_method = $multiplication_method;

        return $this;
    }
}
