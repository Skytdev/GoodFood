<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(attributes={"access_control"="is_granted('PUBLIC_ACCESS')"})
 * @ORM\Entity(repositoryClass=ProductCategoryRepository::class)
 * @ApiFilter(SearchFilter::class, properties={
 *     "name": "partial",
 *     "createdAt": "exact",
 *     "franchises.id": "exact"
 * })
 */
class ProductCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Le nom doit avoir au minimum {{ limit }} caracteres",
     *      maxMessage = "Le nom doit avoir au maximum {{ limit }} caracteres"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="categories")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Franchise::class, inversedBy="productCategories")
     */
    private $franchises;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->franchises = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Franchise[]
     */
    public function getFranchises(): Collection
    {
        return $this->franchises;
    }

    public function addFranchise(Franchise $franchise): self
    {
        if (!$this->franchises->contains($franchise)) {
            $this->franchises[] = $franchise;
        }

        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        $this->franchises->removeElement($franchise);

        return $this;
    }
}
