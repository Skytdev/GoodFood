<?php

namespace App\Entity;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\IngredientRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(attributes={"access_control"="is_granted('PUBLIC_ACCESS')"})
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 * @ApiFilter(SearchFilter::class, strategy="partial")
 * @ApiFilter(OrderFilter::class)
 */
class Ingredient extends Article
{

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Le nom doit avoir au minimum {{ limit }} caracteres",
     *      maxMessage = "Le nom doit avoir au maximum {{ limit }} caracteres"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "L'unité doit avoir au minimum {{ limit }} caracteres",
     *      maxMessage = "L'unité doit avoir au maximum {{ limit }} caracteres"
     * )
     */
    private $unit;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $stockMin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $allergen;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseIngredient::class, mappedBy="ingredient", orphanRemoval=true)
     */
    private $purchaseIngredients;

    /**
     * @ORM\OneToMany(targetEntity=IngredientProduct::class, mappedBy="ingredient", orphanRemoval=true)
     */
    private $ingredientProducts;

    /**
     * @ORM\OneToMany(targetEntity=Extra::class, mappedBy="ingredient")
     */
    private $extras;

    /**
     * @ORM\Column(type="float")
     */
    private $extraPrice;

    public function __construct()
    {
        $this->ingredientProducts = new ArrayCollection();
        $this->purchaseIngredients = new ArrayCollection();
        $this->extras = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getStockMin(): ?int
    {
        return $this->stockMin;
    }

    public function setStockMin(int $stockMin): self
    {
        $this->stockMin = $stockMin;

        return $this;
    }

    public function getAllergen(): ?string
    {
        return $this->allergen;
    }

    public function setAllergen(?string $allergen): self
    {
        $this->allergen = $allergen;

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
            $purchaseIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removePurchaseIngredient(PurchaseIngredient $purchaseIngredient): self
    {
        if ($this->purchaseIngredients->removeElement($purchaseIngredient)) {
            // set the owning side to null (unless already changed)
            if ($purchaseIngredient->getIngredient() === $this) {
                $purchaseIngredient->setIngredient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IngredientProduct[]
     */
    public function getIngredientProducts(): Collection
    {
        return $this->ingredientProducts;
    }

    public function addIngredientProduct(IngredientProduct $ingredientProduct): self
    {
        if (!$this->ingredientProducts->contains($ingredientProduct)) {
            $this->ingredientProducts[] = $ingredientProduct;
            $ingredientProduct->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientProduct(IngredientProduct $ingredientProduct): self
    {
        if ($this->ingredientProducts->removeElement($ingredientProduct)) {
            // set the owning side to null (unless already changed)
            if ($ingredientProduct->getIngredient() === $this) {
                $ingredientProduct->setIngredient(null);
            }
        }

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
            $extra->setIngredient($this);
        }

        return $this;
    }

    public function removeExtra(Extra $extra): self
    {
        if ($this->extras->removeElement($extra)) {
            // set the owning side to null (unless already changed)
            if ($extra->getIngredient() === $this) {
                $extra->setIngredient(null);
            }
        }

        return $this;
    }

    public function getExtraPrice(): ?float
    {
        return $this->extraPrice;
    }

    public function setExtraPrice(float $extraPrice): self
    {
        $this->extraPrice = $extraPrice;

        return $this;
    }
}
