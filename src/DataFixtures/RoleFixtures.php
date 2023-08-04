<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\EmployeeFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class RoleFixtures extends Fixture
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {

        $role = new Role();
        $role->setValue("ROLE_EMPLOYEE");
        $role->setLabel("Employe");
        $manager->persist($role);

        $role = new Role();
        $role->setValue("ROLE_CUSTOMER");
        $role->setLabel("Client");
        $manager->persist($role);

        $role = new Role();
        $role->setValue("ROLE_ADMIN");
        $role->setLabel("Administrateur");
        $manager->persist($role);

        $role = new Role();
        $role->setValue("ROLE_STOCK");
        $role->setLabel("Stock");
        $manager->persist($role);

        $role = new Role();
        $role->setValue("ROLE_MANAGER");
        $role->setLabel("Responsable");
        $manager->persist($role);

        $role = new Role();
        $role->setValue("ROLE_COOK");
        $role->setLabel("Cuisinier");
        $manager->persist($role);

        $manager->flush();
    }
}
