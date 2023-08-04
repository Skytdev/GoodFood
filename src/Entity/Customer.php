<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\RoleRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ApiResource(attributes={"access_control"="is_granted('PUBLIC_ACCESS')",
 * "normalization_context"={"groups"={"readCustomer"}}, 
 * "denormalization_context"={"groups"={"writeCustomer"}}}
 * )
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ORM\Table(name="customer")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\EntityListeners({"App\EventListener\Entity\CustomerEntityListener"})
 * @ApiFilter(SearchFilter::class, properties={
 *     "email": "partial",
 *     "lastname": "partial",
 *     "firstname": "partial",
 *     "birthday": "partial",
 *     "adresse.id": "exact",
 *     "customerRoles.value": "exact"
 * })
 * @ApiFilter(OrderFilter::class)
 */
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readCustomer"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"readCustomer","writeCustomer"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, inversedBy="customers")
     * @Groups({"readCustomer","writeCustomer"})
     */
    private $customerRoles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string The plain password
     * @Groups({"writeCustomer"}) // Expose using groups
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"readCustomer","writeCustomer"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"readCustomer","writeCustomer"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $firstname;

    /**
     * @ORM\Column(type="date")
     * @Groups({"readCustomer","writeCustomer"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $birthday;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     */
    private $orders;

    /**
     * @ORM\ManyToMany(targetEntity=Address::class, mappedBy="customer")
     * @Groups({"readCustomer"})
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity=OrderNotice::class, mappedBy="customer")
     */
    private $OrderNotice;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"readCustomer","writeCustomer"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"readCustomer","writeCustomer"})
     */
    private $civility;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->OrderNotice = new ArrayCollection();
        $this->customerRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

   /**
     * @return Array
     */
    public function getRoles(): Array
    {
        $roles = array_map(function ($role) { return $role->getValue();}, $this->customerRoles->toArray());
        return $roles;
    }

    /**
     * @return Collection|Roles[]
     */
    public function getCustomerRoles(): Collection
    {
        return $this->customerRoles;
    }

    public function addCustomerRole(Role $role): self
    {
        if (!$this->customerRoles->contains($role)) {
            $this->customerRoles[] = $role;
        }

        return $this;
    }

    public function removeCustomerRole(Role $role): self
    {
        $this->customerRoles->removeElement($role);

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless alreadCustomery changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * Get the plain password
     *
     * @return  string
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the plain password
     *
     * @param  string  $plainPassword  The plain password
     *
     * @return  self
     */ 
    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->addCustomer($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            $address->removeCustomer($this);
        }

        return $this;
    }

    /**
     * @return Collection|OrderNotice[]
     */
    public function getOrderNotice(): Collection
    {
        return $this->OrderNotice;
    }

    public function addOrderNotice(OrderNotice $orderNotice): self
    {
        if (!$this->OrderNotice->contains($orderNotice)) {
            $this->OrderNotice[] = $orderNotice;
            $orderNotice->setCustomer($this);
        }

        return $this;
    }

    public function removeOrderNotice(OrderNotice $orderNotice): self
    {
        if ($this->OrderNotice->removeElement($orderNotice)) {
            // set the owning side to null (unless alreadCustomery changed)
            if ($orderNotice->getCustomer() === $this) {
                $orderNotice->setCustomer(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }
}
