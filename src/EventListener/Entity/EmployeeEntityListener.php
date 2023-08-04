<?php

namespace App\EventListener\Entity;

use App\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoleRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeeEntityListener
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
    public function preUpdateHandler(Employee $user): void
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPassword($this->hasher->hashPassword($user, $user->getPlainPassword()));
        }
        $user->addEmployeeRole($this->roleRepository->findOneByValue('ROLE_EMPLOYEE'));
    }
}