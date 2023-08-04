<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(attributes={"access_control"="is_granted('PUBLIC_ACCESS')"})
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"readEmployee"})
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 9,
     *      max = 100,
     *      minMessage = "Role name must be at least {{ limit }} characters long",
     *      maxMessage = "Role name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Groups({"readEmployee"})
     */
    private $label;

        /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 9,
     *      max = 100,
     *      minMessage = "Role name must be at least {{ limit }} characters long",
     *      maxMessage = "Role name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Groups({"readEmployee"})
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity=Employee::class, inversedBy="employeeRoles")
     */
    private $employees;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="customerRoles")
     */
    private $customers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"readEmployee"})
     */
    private $createdOn;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }

     /**
     * @ORM\PrePersist 
     */ 
    public function setCreatedOnValue()
    {
        $this->createdOn =  new \DateTime();
    }

    /**
     * Get the value of id
     *
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  integer  $id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

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
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            $employee->removeEmployeeRole($this);
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->employees;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customer->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addCustomerRole($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeCustomerRole($this);
        }

        return $this;
    }

    /**
     * Get the value of label
     *
     * @return  string
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @param  string  $label
     *
     * @return  self
     */ 
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return  string
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param  string  $value
     *
     * @return  self
     */ 
    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of createdOn
     *
     * @return  \DateTime
     */ 
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set the value of createdOn
     *
     * @param  \DateTime  $createdOn
     *
     * @return  self
     */ 
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }
}