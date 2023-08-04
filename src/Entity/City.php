<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={"access_control"="is_granted('ROLE_USER')"})
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readCustomer", "order"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"readCustomer", "order"})
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Le nom doit avoir au minimum {{ limit }} caracteres",
     *      maxMessage = "Le nom doit avoir au maximum {{ limit }} caracteres"
     * )
     * @Groups({"readCustomer", "order"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="city", cascade={"persist", "remove"})
     */
    private $adresses;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="cities", cascade={"persist", "remove"})
     * @Assert\NotBlank
     * @Assert\NotNull
     * @ApiProperty(readableLink=true)
     * @Groups({"readCustomer", "order"})
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity=Franchise::class, mappedBy="citiesDelivery")
     */
    private $franchisesDelivery;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->citiesDelivery = new ArrayCollection();
        $this->franchisesDelivery = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
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

    /**
     * @return Collection|Address[]
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Address $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
            $adress->setCity($this);
        }

        return $this;
    }

    public function removeAdress(Address $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getCity() === $this) {
                $adress->setCity(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Franchise[]
     */
    public function getFranchisesDelivery(): Collection
    {
        return $this->franchisesDelivery;
    }

    public function addFranchisesDelivery(Franchise $franchisesDelivery): self
    {
        if (!$this->franchisesDelivery->contains($franchisesDelivery)) {
            $this->franchisesDelivery[] = $franchisesDelivery;
            $franchisesDelivery->addCitiesDelivery($this);
        }

        return $this;
    }

    public function removeFranchisesDelivery(Franchise $franchisesDelivery): self
    {
        if ($this->franchisesDelivery->removeElement($franchisesDelivery)) {
            $franchisesDelivery->removeCitiesDelivery($this);
        }

        return $this;
    }
}
