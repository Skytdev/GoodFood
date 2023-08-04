<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={"access_control"="is_granted('ROLE_USER')"})
 * @ORM\Entity(repositoryClass=PurchaseIngredientRepository::class)
 */
class PurchaseIngredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Purchase::class, inversedBy="purchaseIngredients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchase;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="purchaseIngredients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ingredient;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $qte;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $unitPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->qte;
    }

    public function setQte(float $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
