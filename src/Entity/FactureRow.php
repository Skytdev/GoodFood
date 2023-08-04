<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FactureRowRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FactureRowRepository::class)
 */
class FactureRow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order", "getAllOrder"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="factureRows")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order", "getAllOrder"})
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"order", "getAllOrder"})
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="factureRows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderFinal;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

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

    public function getOrderFinal(): ?Order
    {
        return $this->orderFinal;
    }

    public function setOrderFinal(?Order $orderFinal): self
    {
        $this->orderFinal = $orderFinal;

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

   
}
