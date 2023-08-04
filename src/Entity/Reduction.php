<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReductionRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(attributes={"access_control"="is_granted('PUBLIC_ACCESS')"})
 * @ORM\Entity(repositoryClass=ReductionRepository::class)
 * @ApiFilter(SearchFilter::class, properties={
 *     "name": "partial",
 *     "startDate": "exact",
 *     "endDate": "exact",
 *     "levelPriority": "exact",
 *     "discountRate": "exact",
 *     "franchise.id": "exact"
 * })
 * @ApiFilter(OrderFilter::class)
 */
class Reduction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $levelPriority;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="reductions")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="reductions")
     */
    private $product;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discountRate;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLevelPriority(): ?int
    {
        return $this->levelPriority;
    }

    public function setLevelPriority(?int $levelPriority): self
    {
        $this->levelPriority = $levelPriority;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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

    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(?float $discountRate): self
    {
        $this->discountRate = $discountRate;

        return $this;
    }
}
