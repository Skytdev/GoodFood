<?php

namespace App\DataFixtures;

use App\Entity\Supplier;
use App\Entity\Purchase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PurchaseFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $supplier = $this->doctrine->getRepository(Supplier::class)->findAll();

        $faker = Factory::create();
        
        for ($i = 0; $i < 5; $i++) {
            $purchase = new Purchase();
            $purchase->setCreatedAt($faker->dateTimeBetween('-1 week', '+1 week'));
            $purchase->setDateDelivery($faker->dateTimeBetween('1 week', '+2 week'));
            $purchase->setSupplier($supplier[array_rand($supplier)]);

            $manager->persist($purchase);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SupplierFixtures::class,
        ];
    }
}