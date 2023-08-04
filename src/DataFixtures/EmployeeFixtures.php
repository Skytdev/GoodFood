<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\Franchise;
use App\Entity\Role;
use App\DataFixtures\RoleFixtures;
use App\Repository\RoleRepository;
use App\DataFixtures\FranchiseFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\FranchiseCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;
    private ManagerRegistry $doctrine;

    public function __construct(RoleRepository $roleRepository, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->doctrine = $doctrine;
        $this->roleRepository = $roleRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        $civilities = ['Mme', 'Autre', 'Mr'];
        $franchises = $this->doctrine->getRepository(Franchise::class)->findAll();

        $roleManager = $this->roleRepository->findOneByValue('ROLE_MANAGER');
        $roleStock = $this->roleRepository->findOneByValue('ROLE_STOCK');
        $roleAdmin = $this->roleRepository->findOneByValue('ROLE_ADMIN');
        $roleCook = $this->roleRepository->findOneByValue('ROLE_COOK');

        foreach ($franchises as $franchise) {

            $employee = new Employee();
            $password = $this->hasher->hashPassword($employee, "password");
            $employee->setLastName($faker->lastname());
            $employee->setFirstName($faker->firstname());
            $employee->setPhone("+" . 336 . $faker->randomNumber(8, true));
            $employee->setCivility($civilities[array_rand($civilities)]);
            $employee->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
            $employee->setPassword($password);
            $employee->setFranchise($franchise);
            $employee->addEmployeeRole($roleManager);
            $employee->setEmail("manager_" . $franchise->getId() . "@gmail.com");
            $employee->setCreatedAt($this->getRandomDate());

            $manager->persist($employee);

            $employee = new Employee();
            $password = $this->hasher->hashPassword($employee, "password");
            $employee->setEmail("stock_" . $franchise->getId() . "@gmail.com");
            $employee->setLastName($faker->lastname());
            $employee->setFirstName($faker->firstname());
            $employee->setPhone("+" . 336 . $faker->randomNumber(8, true));
            $employee->setCivility($civilities[array_rand($civilities)]);
            $employee->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
            $employee->setPassword($password);
            $employee->setFranchise($franchise);
            $employee->addEmployeeRole($roleStock);
            $employee->setCreatedAt($this->getRandomDate());

            $manager->persist($employee);

            $employee = new Employee();
            $password = $this->hasher->hashPassword($employee, "password");
            $employee->setEmail("employee_1_" . $franchise->getId() . "@gmail.com");
            $employee->setLastName($faker->lastname());
            $employee->setFirstName($faker->firstname());
            $employee->setPhone("+" . 336 . $faker->randomNumber(8, true));
            $employee->setCivility($civilities[array_rand($civilities)]);
            $employee->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
            $employee->setPassword($password);
            $employee->setFranchise($franchise);
            $employee->addEmployeeRole($roleCook);
            $employee->setCreatedAt($this->getRandomDate());

            $manager->persist($employee);

            $employee = new Employee();
            $password = $this->hasher->hashPassword($employee, "password");
            $employee->setEmail("employee_2_" . $franchise->getId() . "@gmail.com");
            $employee->setLastName($faker->lastname());
            $employee->setFirstName($faker->firstname());
            $employee->setPhone("+" . 336 . $faker->randomNumber(8, true));
            $employee->setCivility($civilities[array_rand($civilities)]);
            $employee->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
            $employee->setPassword($password);
            $employee->setFranchise($franchise);
            $employee->setCreatedAt($this->getRandomDate());

            $manager->persist($employee);

            // $employee = new Employee();
            // $password = $this->hasher->hashPassword($employee, "password");
            // $employee->setEmail("employee_3_" . $franchise->getId() . "@gmail.com");
            // $employee->setLastName($faker->lastname());
            // $employee->setFirstName($faker->firstname());
            // $employee->setPhone("+" . 336 . $faker->randomNumber(8, true));
            // $employee->setCivility($civilities[array_rand($civilities)]);
            // $employee->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
            // $employee->setPassword($password);
            // $employee->setFranchise($franchise);
            // $employee->addEmployeeRole($roleEmployee);
            // $employee->setDesactivatedAt(new \DateTime());
            // $employee->setIsActive(0);

            // $manager->persist($employee);
        }

        $employee = new Employee();
        $password = $this->hasher->hashPassword($employee, "password");
        $employee->setEmail("employeetest@gmail.com");
        $employee->setLastName("Tapon");
        $employee->setFirstName("Gaspard");
        $employee->setPhone("+" . 336 . $faker->randomNumber(8, true));
        $employee->setCivility("Mr");
        $employee->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
        $employee->setPassword($password);
        $employee->addEmployeeRole($roleAdmin);
        $employee->setCreatedAt($this->getRandomDate());
        
        $manager->persist($employee);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FranchiseFixtures::class,
            RoleFixtures::class
        ];
    }

    private function getRandomDate() {
        $timestamp = rand( strtotime("Jan 01 2010"), strtotime("Nov 01 2021") );
        $random_Date = new \DateTime();
        $random_Date->setTimestamp($timestamp);
        return $random_Date;
    }
}
