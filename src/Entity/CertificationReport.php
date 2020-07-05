<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CertificationReportRepository")
 */
class CertificationReport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $checkOrder;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $finished;

    /**
     * @ORM\ManyToOne(targetEntity="Remodeling", inversedBy="certificationReports")
     * @ORM\JoinColumn(name="remodeling_id", referencedColumnName="id", nullable=false)
     */
    private $remodeling;

    public function __construct($checkOrder, $finished)
    {
        $this->setCheckOrder($checkOrder);
        $this->setFinished($finished);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckOrder(): ?int
    {
        return $this->checkOrder;
    }

    public function setCheckOrder(int $checkOrder): self
    {
        $this->checkOrder = $checkOrder;

        return $this;
    }

    public function getRemodeling()
    {
        return $this->remodeling;
    }

    public function setRemodeling($remodeling): void
    {
        $this->remodeling = $remodeling;
    }

    public function getFinished()
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }
}