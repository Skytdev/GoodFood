<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Reduction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReductionFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $product = $this->doctrine->getRepository(Product::class)->findAll();

        $faker = Factory::create();
        
        for ($i = 0; $i < 5; $i++) {
            $reduction = new Reduction();
            $reduction->setName('Reduction'.$i);
            $reduction->setStartDate($faker->dateTimeBetween('-1 week', '+1 week'));
            $reduction->setEndDate($faker->dateTimeBetween('-1 week', '+1 week'));
            $reduction->setLevelPriority($faker->numberBetween(1, 3));
            $reduction->setDiscountRate(0.1*($i + 1));
            $reduction->setProduct($product[array_rand($product)]);
            $manager->persist($reduction);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}