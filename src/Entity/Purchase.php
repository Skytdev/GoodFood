<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(attributes={"access_control"="is_granted('ROLE_USER')"})
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDelivery;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseIngredient::class, mappedBy="purchase", orphanRemoval=true)
     */
    private $purchaseIngredients;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplier;

    public function __construct()
    {
        $this->purchaseIngredients = new ArrayCollection();
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

    public function getDateDelivery(): ?\DateTimeInterface
    {
        return $this->dateDelivery;
    }

    public function setDateDelivery(?\DateTimeInterface $dateDelivery): self
    {
        $this->dateDelivery = $dateDelivery;

        return $this;
    }

    /**
     * @return Collection|PurchaseIngredient[]
     */
    public function getPurchaseIngredients(): Collection
    {
        return $this->purchaseIngredients;
    }

    public function addPurchaseIngredient(PurchaseIngredient $purchaseIngredient): self
    {
        if (!$this->purchaseIngredients->contains($purchaseIngredient)) {
            $this->purchaseIngredients[] = $purchaseIngredient;
            $purchaseIngredient->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseIngredient(PurchaseIngredient $purchaseIngredient): self
    {
        if ($this->purchaseIngredients->removeElement($purchaseIngredient)) {
            // set the owning side to null (unless already changed)
            if ($purchaseIngredient->getPurchase() === $this) {
                $purchaseIngredient->setPurchase(null);
            }
        }

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }
}
