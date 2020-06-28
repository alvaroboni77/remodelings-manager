<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuilderRepository")
 */
class Builder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @Assert\Email(
     *     message = "El email '{{ value }}' no es un email válido."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Remodeling", mappedBy="builder")
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
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
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
            $remodeling->setBuilder($this);
        }

        return $this;
    }

    public function removeRemodeling(Remodeling $remodeling): self
    {
        if ($this->remodelings->contains($remodeling)) {
            $this->remodelings->removeElement($remodeling);
            if ($remodeling->getBuilder() === $this) {
                $remodeling->setBuilder(null);
            }
        }

        return $this;
    }
}
