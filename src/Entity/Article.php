<?php

namespace App\Entity;

use App\Entity\Franchise;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "ingredient" = "Ingredient",
 *      "product" = "Product",
 *      "menu" = "Menu"
 * })
 * @ApiFilter(SearchFilter::class, properties={
 *     "franchise.id": "exact",
 * })
 * @ApiFilter(OrderFilter::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=FactureRow::class, mappedBy="article")
     */
    private $factureRows;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @ApiProperty(readableLink=true)
     */
    private $franchise;

    public function __construct()
    {
        $this->factureRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|FactureRow[]
     */
    public function getFactureRows(): Collection
    {
        return $this->factureRows;
    }

    public function addFactureRow(FactureRow $factureRow): self
    {
        if (!$this->factureRows->contains($factureRow)) {
            $this->factureRows[] = $factureRow;
            $factureRow->setArticle($this);
        }

        return $this;
    }

    public function removeFactureRow(FactureRow $factureRow): self
    {
        if ($this->factureRows->removeElement($factureRow)) {
            // set the owning side to null (unless already changed)
            if ($factureRow->getArticle() === $this) {
                $factureRow->setArticle(null);
            }
        }

        return $this;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

        return $this;
    }
}
