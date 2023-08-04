<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoleRepository;
use App\Repository\EmployeeRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\EventListener\Entity\EmployeeEntityListener;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ApiResource(attributes={
 * "normalization_context"={"groups"={"readEmployee"}}, 
 * "denormalization_context"={"groups"={"writeEmployee"}}
 * }
 * )
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @ORM\Table(name="employee")
 * @ORM\EntityListeners({"App\EventListener\Entity\EmployeeEntityListener"})
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={
 *     "email": "partial",
 *     "lastname": "partial",
 *     "firstname": "partial",
 *     "birthday": "partial",
 *     "franchise.id": "exact",
 *     "franchise.name": "partial",
 *     "employeeRoles.value" : "exact",
 *     "civility": "partial"
 * })
 * @ApiFilter(OrderFilter::class, properties={
 *     "email",
 *     "lastname",
 *     "firstname",
 *     "birthday",
 *     "franchise.name",
 *     "civility",
 *     "phone",
 *     "isActive",
 *     "createdAt",
 *     "desactivatedAt"
 * })
 */
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readEmployee"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"readEmployee","writeEmployee"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="employees")
     * @Groups({"readEmployee","writeEmployee"})
     */
    private $employeeRoles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string The plain password
     * @Groups({"writeEmployee"}) // Expose using groups
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"readEmployee","writeEmployee"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"readEmployee","writeEmployee"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $firstname;

    /**
     * @ORM\Column(type="date")
     * @Groups({"readEmployee","writeEmployee"})
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $birthday;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="employees")
     * @Groups({"readEmployee","writeEmployee"})
     */
    private $franchise;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"readEmployee","writeEmployee"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"readEmployee","writeEmployee"})
     */
    private $civility;

    /**
     * @ORM\Column(type="boolean", options={"default":"1"})
     * @Groups({"readEmployee","writeEmployee"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="date")
     * @Groups({"readEmployee"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"readEmployee","writeEmployee"})
     */
    private $desactivatedAt;

    public function __construct()
    {
        $this->employeeRoles = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getCreatedAt()) {
            $this->createdAt = new \DateTime();
        }
    }

     /**
     * @ORM\PrePersist
     */
    public function setIsActiveValue()
    {
        $this->isActive = true;
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
    public function getRoles(): array
    {
        $roles = array_map(function ($role) {
            return $role->getValue();
        }, $this->employeeRoles->toArray());
        return $roles;
    }

    /**
     * @return Collection|Roles[]
     */
    public function getEmployeeRoles(): Collection
    {
        return $this->employeeRoles;
    }

    public function addEmployeeRole(Role $role): self
    {
        if (!$this->employeeRoles->contains($role)) {
            $this->employeeRoles[] = $role;
            $role->addEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeRole(Role $role): self
    {
        if ($this->employeeRoles->removeElement($role)) {
            $role->removeEmployee($this);
        }
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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
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

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDesactivatedAt(): ?\DateTime
    {
        return $this->desactivatedAt;
    }

    public function setDesactivatedAt(?\DateTime $desactivatedAt): self
    {
        $this->desactivatedAt = $desactivatedAt;

        return $this;
    }
}
