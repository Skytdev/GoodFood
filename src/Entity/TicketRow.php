<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TicketRowRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TicketRowRepository::class)
 */
class TicketRow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="ticketRows")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="ticketRows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderFinal;

    /**
     * @ORM\OneToMany(targetEntity=Extra::class, mappedBy="TicketRow")
     * @Groups({"order"})
     */
    private $extras;

    public function __construct()
    {
        $this->extras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrderFinal(): ?Order
    {
        return $this->orderFinal;
    }

    public function setOrderFinal(?Order $orderFinal): self
    {
        $this->orderFinal = $orderFinal;

        return $this;
    }

    /**
     * @return Collection|Extra[]
     */
    public function getExtras(): Collection
    {
        return $this->extras;
    }

    public function addExtra(Extra $extra): self
    {
        if (!$this->extras->contains($extra)) {
            $this->extras[] = $extra;
            $extra->setTicketRow($this);
        }

        return $this;
    }

    public function removeExtra(Extra $extra): self
    {
        if ($this->extras->removeElement($extra)) {
            // set the owning side to null (unless already changed)
            if ($extra->getTicketRow() === $this) {
                $extra->setTicketRow(null);
            }
        }

        return $this;
    }
}
