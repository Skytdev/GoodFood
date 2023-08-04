<?php

namespace App\Entity;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Secured resource.
 *
 * @ApiResource(
 *     attributes={"access_control"="is_granted('PUBLIC_ACCESS')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('PUBLIC_ACCESS')"},
 *         "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "patch"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ApiResource(attributes={"access_control"="is_granted('ROLE_USER')"})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 *  @ApiFilter(SearchFilter::class, properties={
 *     "name": "partial",
 *     "price": "exact",
 *     "createdAt": "exact",
 *     "price": "exact",
 *     "reductions": "exact",
 *     "categories.id": "exact",
 *     "franchise.id": "exact"
 * })
 * @ApiFilter(OrderFilter::class)
 */
class Product extends Article
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
     * @Groups({"order"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=ProductCategory::class, inversedBy="products")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=IngredientProduct::class, mappedBy="product", orphanRemoval=true)
     * @ApiProperty(readableLink=true)
     */
    private $ingredientProducts;

    /**
     * @ORM\OneToMany(targetEntity=Reduction::class, mappedBy="product")
     */
    private $reductions;

    /**
     * @ORM\ManyToMany(targetEntity=Menu::class, inversedBy="products")
     */
    private $menu;

     /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(readableLink=true)
     */
    public $image;

    /**
     * @ORM\OneToMany(targetEntity=TicketRow::class, mappedBy="product")
     */
    private $ticketRows;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->ingredientProducts = new ArrayCollection();
        $this->reductions = new ArrayCollection();
        $this->menu = new ArrayCollection();
        $this->ticketRows = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
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
     * @return Collection|ProductCategory[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ProductCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(ProductCategory $category): self
    {
        $this->categories->removeElement($category);

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
            $ingredientProduct->setProduct($this);
        }

        return $this;
    }

    public function removeIngredientProduct(IngredientProduct $ingredientProduct): self
    {
        if ($this->ingredientProducts->removeElement($ingredientProduct)) {
            // set the owning side to null (unless already changed)
            if ($ingredientProduct->getProduct() === $this) {
                $ingredientProduct->setProduct(null);
            }
        }

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
            $reduction->setProduct($this);
        }

        return $this;
    }

    public function removeReduction(Reduction $reduction): self
    {
        if ($this->reductions->removeElement($reduction)) {
            // set the owning side to null (unless already changed)
            if ($reduction->getProduct() === $this) {
                $reduction->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menu->removeElement($menu);

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
            $ticketRow->setProduct($this);
        }

        return $this;
    }

    public function removeTicketRow(TicketRow $ticketRow): self
    {
        if ($this->ticketRows->removeElement($ticketRow)) {
            // set the owning side to null (unless already changed)
            if ($ticketRow->getProduct() === $this) {
                $ticketRow->setProduct(null);
            }
        }

        return $this;
    }
}
