<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FranchiseRepository;
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
 * @ApiResource(
 *  attributes={"access_control"="is_granted('PUBLIC_ACCESS')"}
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *     "name": "partial",
 *     "costDelivery": "exact",
 *     "citiesDelivery.cp": "exact",
 *     "categories.name": "partial"
 * })
 * @ApiFilter(OrderFilter::class)
 * @ORM\Entity(repositoryClass=FranchiseRepository::class)
 */
class Franchise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readEmployee", "order"})
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
     * @Groups({"readEmployee", "order"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $costDelivery;

    /**
     * @ORM\ManyToMany(targetEntity=FranchiseCategory::class, inversedBy="franchises")
     * @ApiProperty(readableLink=true)
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, mappedBy="franchise")
     */
    private $suppliers;

    /**
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="franchise")
     */
    private $employees;

     /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(readableLink=true)
     */
    public $image;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="franchise")
     */
    private $orders;
    
    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="franchise", orphanRemoval=true)
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="franchise")
     * @ORM\JoinColumn(nullable=false)
     * @ApiProperty(readableLink=true)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity=City::class, inversedBy="franchisesDelivery")
     */
    private $citiesDelivery;

    /**
     * @ORM\ManyToMany(targetEntity=ProductCategory::class, mappedBy="franchises")
     * @ApiProperty(readableLink=true)
     */
    private $productCategories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->employees = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->citiesDelivery = new ArrayCollection();
        $this->productCategories = new ArrayCollection();
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

    public function getCostDelivery(): ?int
    {
        return $this->costDelivery;
    }

    public function setCostDelivery(?int $costDelivery): self
    {
        $this->costDelivery = $costDelivery;

        return $this;
    }

    /**
     * @return Collection|FranchiseCategory[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(FranchiseCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(FranchiseCategory $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
            $supplier->addFranchise($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        if ($this->suppliers->removeElement($supplier)) {
            $supplier->removeFranchise($this);
        }

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setFranchise($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getFranchise() === $this) {
                $employee->setFranchise(null);
            }
        }

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

    /**
     * @return Collection|City[]
     */
    public function getCitiesDelivery(): Collection
    {
        return $this->citiesDelivery;
    }

    public function addCitiesDelivery(City $citiesDelivery): self
    {
        if (!$this->citiesDelivery->contains($citiesDelivery)) {
            $this->citiesDelivery[] = $citiesDelivery;
        }

        return $this;
    }

    public function removeCitiesDelivery(City $citiesDelivery): self
    {
        $this->citiesDelivery->removeElement($citiesDelivery);

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
            $order->setFranchise($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getFranchise() === $this) {
                $order->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setFranchise($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getFranchise() === $this) {
                $article->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductCategory[]
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    public function addProductCategory(ProductCategory $productCategory): self
    {
        if (!$this->productCategories->contains($productCategory)) {
            $this->productCategories[] = $productCategory;
            $productCategory->addFranchise($this);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): self
    {
        if ($this->productCategories->removeElement($productCategory)) {
            $productCategory->removeFranchise($this);
        }

        return $this;
    }
}
