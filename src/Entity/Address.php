<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AddressRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={"access_control"="is_granted('ROLE_USER')"})
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readCustomer", "order"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"readCustomer", "order"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Type("string")
     * @Groups({"readCustomer", "order"})
     */
    private $channel;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 1,
     *      max = 30,
     *      minMessage = "L'adresse doit avoir au minimum {{ limit }} caracteres",
     *      maxMessage = "L'adresse doit avoir au maximum {{ limit }} caracteres"
     * )
     * @Groups({"readCustomer", "order"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="adresses", cascade={"persist", "remove"})
     * @Assert\Type("integer")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @ApiProperty(readableLink=true)
     * @Groups({"readCustomer", "order"})
     */
    private $city;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, inversedBy="addresses")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=Supplier::class, mappedBy="address")
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="address")
     */
    private $orders;
    
    /**
     * @ORM\OneToMany(targetEntity=Franchise::class, mappedBy="address")
     */
    private $franchise;

    public function __construct()
    {
        $this->customer = new ArrayCollection();
        $this->supplier = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->franchise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): self
    {
        $this->channel = $channel;

        return $this;
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customer->contains($customer)) {
            $this->customer[] = $customer;
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        $this->customer->removeElement($customer);

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSupplier(): Collection
    {
        return $this->supplier;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->supplier->contains($supplier)) {
            $this->supplier[] = $supplier;
            $supplier->setAddress($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        if ($this->supplier->removeElement($supplier)) {
            // set the owning side to null (unless already changed)
            if ($supplier->getAddress() === $this) {
                $supplier->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setAddress($this);
        }

        return $this;
    }

    /**
     * @return Collection|Franchise[]
     */
    public function getFranchise(): Collection
    {
        return $this->franchise;
    }

    public function addFranchise(Franchise $franchise): self
    {
        if (!$this->franchise->contains($franchise)) {
            $this->franchise[] = $franchise;
            $franchise->setAddress($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getAddress() === $this) {
                $order->setAddress(null);
            }
        }
        
        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        if ($this->franchise->removeElement($franchise)) {
            // set the owning side to null (unless already changed)
            if ($franchise->getAddress() === $this) {
                $franchise->setAddress(null);
            }
        }

        return $this;
    }
}
