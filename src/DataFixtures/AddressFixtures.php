<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $cities = $this->doctrine->getRepository(City::class)->findAll();

        $faker = Factory::create();

        for ($i = 0; $i < 150; ++$i) {
            $adress = new Address();
            $adress->setName($faker->streetName);
            $adress->setNumber($faker->buildingNumber);
            $adress->setChannel($faker->streetSuffix);
            $adress->setCity($cities[array_rand($cities)]);
            $manager->persist($adress);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CityFixtures::class,
        ];
    }
}
