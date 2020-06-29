<?php

namespace App\Entity;

use App\Repository\DelayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DelayRepository::class)
 */
class Delay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $days;

    /**
     * @ORM\ManyToOne(targetEntity=Remodeling::class, inversedBy="delays")
     * @ORM\JoinColumn(name="remodeling_id", referencedColumnName="id",nullable=false)
     */
    private $remodeling;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDays(): ?string
    {
        return $this->days;
    }

    public function setDays(string $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getRemodeling(): ?Remodeling
    {
        return $this->remodeling;
    }

    public function setRemodeling(?Remodeling $remodeling): self
    {
        $this->remodeling = $remodeling;

        return $this;
    }
}
