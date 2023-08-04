<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={"access_control"="is_granted('ROLE_USER')"})
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 */
class Supplier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Purchase::class, mappedBy="supplier")
     */
    private $purchases;

    /**
     * @ORM\ManyToMany(targetEntity=Franchise::class, inversedBy="suppliers")
     */
    private $franchise;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="supplier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->franchise = new ArrayCollection();
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

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setSupplier($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getSupplier() === $this) {
                $purchase->setSupplier(null);
            }
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
        }

        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        $this->franchise->removeElement($franchise);

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
