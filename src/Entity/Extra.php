<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExtraRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ExtraRepository::class)
 */
class Extra
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"order"})
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=TicketRow::class, inversedBy="extras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TicketRow;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="extras")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order"})
     */
    private $ingredient;

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

    public function getTicketRow(): ?TicketRow
    {
        return $this->TicketRow;
    }

    public function setTicketRow(?TicketRow $TicketRow): self
    {
        $this->TicketRow = $TicketRow;

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
}
