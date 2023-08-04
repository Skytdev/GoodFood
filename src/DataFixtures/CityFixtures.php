<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CityFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $countries = $this->doctrine->getRepository(Country::class)->findAll();

        $faker = Factory::create();

        for ($i = 0; $i < 50; ++$i) {
            $city = new City();
            $city->setCp(random_int(9999, 99999));
            $city->setName($faker->city);
            $city->setCountry($countries[array_rand($countries)]);

            $manager->persist($city);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CountryFixtures::class,
        ];
    }
}
