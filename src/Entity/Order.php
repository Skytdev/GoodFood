<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\OrderGetAction;
use App\Controller\OrderController;
use App\Repository\OrderRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(attributes={"force_eager"=false,"security"="is_granted('PUBLIC_ACCESS')", "enable_max_depth"=true,
 * "normalization_context"={"groups"={"order"}}}, 
 *  collectionOperations={
 *         "get",
 *         "post"={
 *             "controller"=OrderController::class,
 *              "deserialize"=false,
 *          }
 * }
 * )
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={
 *     "createdAt": "partial",
 *     "state.id": "exact",
 *     "customer.id": "exact",
 *     "franchise.id": "exact"
 * })
 * @ApiFilter(OrderFilter::class)
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"order"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=OrderState::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order"})
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"order"})
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity=OrderNotice::class, inversedBy="orderfield", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"order"})
     */
    private $OrderNotice;

    /**
     * @ORM\OneToMany(targetEntity=FactureRow::class, mappedBy="orderFinal")
     * @ApiProperty(readableLink=true)
     * @Groups({"order"})
     */
    private $factureRows;

    /**
     * @ORM\OneToMany(targetEntity=TicketRow::class, mappedBy="orderFinal")
     * @ApiProperty(readableLink=true)
     * @Groups({"order"})
     */
    private $ticketRows;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order"})
     */
    private $franchise;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order"})
     * @ApiProperty(readableLink=true)
     */
    private $address;

    public function __construct()
    {
        $this->factureRows = new ArrayCollection();
        $this->ticketRows = new ArrayCollection();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getState(): ?OrderState
    {
        return $this->state;
    }

    public function setState(?OrderState $state): self
    {
        $this->state = $state;

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

    public function getOrderNotice(): ?OrderNotice
    {
        return $this->OrderNotice;
    }

    public function setOrderNotice(OrderNotice $OrderNotice): self
    {
        $this->OrderNotice = $OrderNotice;

        return $this;
    }

    /**
     * @return Collection|FactureRow[]
     */
    public function getFactureRows(): Collection
    {
        return $this->factureRows;
    }

    public function addFactureRow(FactureRow $factureRow): self
    {
        if (!$this->factureRows->contains($factureRow)) {
            $this->factureRows[] = $factureRow;
            $factureRow->setOrderFinal($this);
        }

        return $this;
    }

    public function removeFactureRow(FactureRow $factureRow): self
    {
        if ($this->factureRows->removeElement($factureRow)) {
            // set the owning side to null (unless already changed)
            if ($factureRow->getOrderFinal() === $this) {
                $factureRow->setOrderFinal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TicketRow[]
     */
    public function getTicketRows(): Collection
    {
        return $this->ticketRows;
    }

    public function addTicketRow(TicketRow $ticketRow): self
    {
        if (!$this->ticketRows->contains($ticketRow)) {
            $this->ticketRows[] = $ticketRow;
            $ticketRow->setOrderFinal($this);
        }

        return $this;
    }

    public function removeTicketRow(TicketRow $ticketRow): self
    {
        if ($this->ticketRows->removeElement($ticketRow)) {
            // set the owning side to null (unless already changed)
            if ($ticketRow->getOrderFinal() === $this) {
                $ticketRow->setOrderFinal(null);
            }
        }

        return $this;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

}
