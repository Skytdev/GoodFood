<?php

namespace App\Entity;

use App\Repository\OrderNoticeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderNoticeRepository::class)
 */
class OrderNotice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="OrderNotice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="OrderNotice", cascade={"persist", "remove"})
     */
    private $orderfield;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOrderfield(): ?Order
    {
        return $this->orderfield;
    }

    public function setOrderfield(Order $orderfield): self
    {
        // set the owning side of the relation if necessary
        if ($orderfield->getOrderNotice() !== $this) {
            $orderfield->setOrderNotice($this);
        }

        $this->orderfield = $orderfield;

        return $this;
    }
}
