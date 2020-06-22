<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArchitectRepository")
 */
class Architect
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Remodeling", mappedBy="architect")
     */
    private $remodelings;

    public function __construct()
    {
        $this->remodelings = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Remodeling[]
     */
    public function getRemodelings(): Collection
    {
        return $this->remodelings;
    }

    public function addRemodeling(Remodeling $remodeling): self
    {
        if (!$this->remodelings->contains($remodeling)) {
            $this->remodelings[] = $remodeling;
            $remodeling->setArchitect($this);
        }

        return $this;
    }

    public function removeRemodeling(Remodeling $remodeling): self
    {
        if ($this->remodelings->contains($remodeling)) {
            $this->remodelings->removeElement($remodeling);
            // set the owning side to null (unless already changed)
            if ($remodeling->getArchitect() === $this) {
                $remodeling->setArchitect(null);
            }
        }

        return $this;
    }
}
