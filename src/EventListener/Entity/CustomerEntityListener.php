<?php

namespace App\EventListener\Entity;

use App\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoleRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerEntityListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher, RoleRepository $roleRepository)
    {
        $this->hasher = $hasher;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @ORM\PrePersist()
     */
    public function preUpdateHandler(Customer $user): void
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPassword($this->hasher->hashPassword($user, $user->getPlainPassword()));
        }
        $user->addCustomerRole($this->roleRepository->findOneByValue('ROLE_CUSTOMER'));
    }
}