<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SupplierFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $adresses = $this->doctrine->getRepository(Address::class)->findAll();

        $faker = Factory::create();
        
        for ($i = 0; $i < 20; $i++) {
            $supplier = new Supplier();
            $supplier->setName($faker->company);
            $supplier->setAddress($adresses[array_rand($adresses)]);
            $manager->persist($supplier);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class
        ];
    }
}