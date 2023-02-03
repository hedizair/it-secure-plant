<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WaterLevelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WaterLevelRepository::class)]
#[ApiResource]
class WaterLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $level = null;

    #[ORM\Column]
    private ?float $threshold = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?float
    {
        return $this->level;
    }

    public function setLevel(float $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getThreshold(): ?float
    {
        return $this->threshold;
    }

    public function setThreshold(float $threshold): self
    {
        $this->threshold = $threshold;

        return $this;
    }
}
