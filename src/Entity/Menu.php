<?php

namespace App\Entity;

use App\Entity\Article;
use App\Entity\Product;
use App\Entity\Reduction;
use App\Entity\MediaObject;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Secured resource.
 *
 * @ApiResource(
 *     attributes={"access_control"="is_granted('PUBLIC_ACCESS')","enable_max_depth"=true,"force_eager"=false},
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('PUBLIC_ACCESS')", "normalization_context"={"groups"={"readMenu"}}},
 *         "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "patch"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 * @ApiFilter(SearchFilter::class, properties={
 *     "name": "partial",
 *     "price": "exact",
 *     "createdAt": "exact",
 *     "price": "exact",
 *     "reductions": "exact",
 *     "products": "exact",
 *     "categories.name": "partial",
 *     "franchise.id": "exact"
 * })
 * @ApiFilter(OrderFilter::class)
 */
class Menu extends Article
{
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Reduction::class, mappedBy="menu")
     */
    private $reductions;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="menu")
     * @ApiProperty(readableLink=true)
     */
    private $products;

     /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(readableLink=true)
     */
    public $image;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->reductions = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

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
     * @return Collection|Reduction[]
     */
    public function getReductions(): Collection
    {
        return $this->reductions;
    }

    public function addReduction(Reduction $reduction): self
    {
        if (!$this->reductions->contains($reduction)) {
            $this->reductions[] = $reduction;
            $reduction->setMenu($this);
        }

        return $this;
    }

    public function removeReduction(Reduction $reduction): self
    {
        if ($this->reductions->removeElement($reduction)) {
            // set the owning side to null (unless already changed)
            if ($reduction->getMenu() === $this) {
                $reduction->setMenu(null);
            }
        }

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
            $product->addMenu($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeMenu($this);
        }

        return $this;
    }
}
