<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IngredientProductRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={"access_control"="is_granted('PUBLIC_ACCESS')"})
 * @ORM\Entity(repositoryClass=IngredientProductRepository::class)
 */
class IngredientProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readMenu"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="ingredientProducts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"readMenu"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="ingredientProducts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"readMenu"})
     * @ApiProperty(readableLink=true)
     */
    private $ingredient;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"readMenu"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"readMenu"})
     */
    private $isExtra;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"readMenu"})
     */
    private $limitQuantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;
        return $this;
    }

    public function getIsExtra(): ?bool
    {
        return $this->isExtra;
    }

    public function setIsExtra(bool $isExtra): self
    {
        $this->isExtra = $isExtra;

        return $this;
    }

    public function getLimitQuantity(): ?int
    {
        return $this->limitQuantity;
    }

    public function setLimitQuantity(int $limitQuantity): self
    {
        $this->limitQuantity = $limitQuantity;

        return $this;
    }

}
