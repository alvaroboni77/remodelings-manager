<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RemodelingRepository")
 */
class Remodeling
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $builtArea;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $constructionTime;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Builder", inversedBy="siteProjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $builder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Architect", inversedBy="siteProjects")
     * @ORM\JoinColumn(name="architect_id", referencedColumnName="id", nullable=false)
     */
    private $architect;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TechnicalArchitect", inversedBy="siteProjects")
     * @ORM\JoinColumn(name="technical_architect_id", referencedColumnName="id", nullable=false)
     */
    private $technicalArchitect;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBuiltArea(): ?int
    {
        return $this->builtArea;
    }

    public function setBuiltArea(int $builtArea): self
    {
        $this->builtArea = $builtArea;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getConstructionTime(): ?int
    {
        return $this->constructionTime;
    }

    public function setConstructionTime(int $constructionTime): self
    {
        $this->constructionTime = $constructionTime;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBuilder(): ?Builder
    {
        return $this->builder;
    }

    public function setBuilder(?Builder $builder): self
    {
        $this->builder = $builder;

        return $this;
    }

    public function getArchitect(): ?Architect
    {
        return $this->architect;
    }

    public function setArchitect(?Architect $architect): self
    {
        $this->architect = $architect;

        return $this;
    }

    public function getTechnicalArchitect(): ?TechnicalArchitect
    {
        return $this->technicalArchitect;
    }

    public function setTechnicalArchitect(?TechnicalArchitect $technicalArchitect): self
    {
        $this->technicalArchitect = $technicalArchitect;

        return $this;
    }
}
